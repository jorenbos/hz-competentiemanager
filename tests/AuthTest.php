<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
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
      $this->visit('/logout')
           ->seePageIs('/');
    }

    public function testLogin()
    {
      $this->visit('/login')
           ->type('johndoe@example.com', 'email')
           ->type('admin123', 'password')
           ->press('Sign in')
           ->seePageIs('/dashboard');
    }
}
