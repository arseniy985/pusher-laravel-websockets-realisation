<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class MessagePolicy
{
    public function store(): bool
    {
        return Auth::check();
    }
}
