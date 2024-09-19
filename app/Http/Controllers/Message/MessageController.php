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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    private string $cachePrefix = 'messages';

    public function index(IndexMessageRequest $request): JsonResponse
    {
        $page = $request->get('page', 0);
        $messages = Cache::tags($this->cachePrefix)->remember($this->cachePrefix . ':' . $page, now()->addDay(), function () use ($page) {
            return DB::table('messages')
                ->select('message', 'messages.created_at', 'user_id', DB::raw('users.login as user_login'))
                ->join('users', 'messages.user_id', '=', 'users.id')
                ->orderBy('messages.created_at', 'desc')
                ->skip(20 * $page)
                ->take(20)
                ->get();
        });

        return response()->json($messages);
    }

    public function store(MessageRequest $request): JsonResponse
    {
        if (!Gate::allows('store_message')) {
            return response()->json(['success' => false, 'error' => 'Вы не авторизованы']);
        }
        if (Str::length($request->text) == 0) {
            return response()->json(['success' => false, 'error' => 'Сообщение не может быть пустым']);
        }

        $message = Message::create([
            'message' => $request->text,
            'user_id' => Auth::user()->id
        ]);
        Cache::tags('messages')->flush();

        event(new StoreMessageEvent([
            'message' => $message->message,
            'user_id' => $message->user_id,
            'user' => [
                'login' => Auth::user()->login
            ]
        ]));

        return response()->json(['success' => true], 201);
    }
}

