<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessagePolicy
{
    public function store(): bool
    {
        return Auth::check();
    }
}
