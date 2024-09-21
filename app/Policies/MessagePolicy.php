<?php

namespace App\Policies;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessagePolicy
{
    public function store(): bool
    {
        return Auth::check();
    }

    public function destroy(Message $message): bool
    {
        return Auth::check() && Auth::user()->id == $message->user_id;
    }

    public function edit(Message $message): bool
    {
        return Auth::check() && Auth::user()->id == $message->user_id;
    }
}
