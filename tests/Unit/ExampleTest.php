<?php

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('can create account', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user);
    $response->assertStatus(302);
    $response->assertRedirect('/');
    $response->assertSessionHasNoErrors();
});

it('can send message', function () {
    $user = User::factory()->create();
    $message = Message::factory()->make([
        'user_id' => $user->id,
    ]);
});
