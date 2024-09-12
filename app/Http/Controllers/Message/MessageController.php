<?php

namespace App\Http\Controllers\Message;

use App\Events\StoreMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Message\IndexMessageRequest;
use App\Http\Requests\Message\MessageRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    private string $cachePrefix = 'messages';

    public function index(IndexMessageRequest $request): JsonResponse
    {
        $messages = Cache::rememberForever($this->cachePrefix . ':all', function () {
            return Message::all()->select(['message', 'updated_at', 'user']);
        });
//        $messages = Message::with('user')->orderBy('id')->paginate(20);

        return response()->json($messages);
    }

    public function store(MessageRequest $request): JsonResponse
    {
        if (! Gate::allows('store')) {
            return response()->json(['success' => false, 'error' => 'Вы не авторизованы']);
        }
        if (Str::length($request->text) == 0) {
            return response()->json(['error' => 'Сообщение не может быть пустым']);
        }
        $messageData = [
            'message' => $request->text,
            'user_id' => Auth::user()->id
        ];
        $pusherData = [
            'message' => $request->text,
            'user' => [
                'id' => Auth::id(),
                'login' => Auth::user()->login,
            ]
        ];
        Message::create($messageData);

        event(new StoreMessageEvent($pusherData));

        Cache::forget($this->cachePrefix . ':all');
        return response()->json(['success' => true], 201);
    }
}

