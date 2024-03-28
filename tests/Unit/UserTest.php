<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;


class UserTest extends TestCase
{
  use RefreshDatabase;

  public function CreateUSer_test()
  {
      $response = $this->post('/api/auth/register', [
          'name' => 'Test User',
          'email' => 'test@example.com',
          'password' => 'password',
      ]);

      $response->assertStatus(201);
      $this->assertCount(1, User::all());
  }
}
