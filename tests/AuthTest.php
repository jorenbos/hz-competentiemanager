<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{

  use DatabaseMigrations;

  public function testRegister()
  {
    $this->visit('/register')
         ->type('John Doe', 'name')
         ->type('johndoe@example.com', 'email')
         ->type('admin123', 'password')
         ->type('admin123', 'password_confirmation')
         ->press('Register')
         ->seePageIs('/dashboard');
  }

  public function testLogout()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user)
         ->visit('/logout')
         ->seePageIs('/');
  }

  public function testLogin()
  {
    $user = User::create([
      'name' => 'John Doe',
      'email' => 'johndoe@example.com',
      'password' => bcrypt('admin123')
    ]);

    $this->visit('/login')
         ->type('johndoe@example.com', 'email')
         ->type('admin123', 'password')
         ->press('Sign in')
         ->seePageIs('/dashboard');
  }
}
