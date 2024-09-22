<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessagePolicy
{
    public function store(): bool
    {
        return Auth::check();
    }

    public function destroy(User $user, $message): bool
    {
        return Auth::check() && $user->id == $message->user_id;
    }

    public function edit(User $user, $message): bool
    {
        return Auth::check() && $user->id == $message->user_id;
    }
}
