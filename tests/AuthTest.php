<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{

    use DatabaseMigrations;


    /**
   * Test the registration functionality of the application by visiting the
   * register page, filling out some dummy information, then pressing the
   * Register button. If we het redirected to the dashboard page, we know we're
   * registered and logged in.
   */
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

    /**
   * Creates a user to mock the Authentication step. Then, attempts to logout
   * the user and see if they are redirected to the homepage.
   *
   * Next, to make sure the application also logs out the user we assert that
   * Auth::check() fails (there is no authenticated user left)
   */
    public function testLogout()
    {
        //Create mock user
        $user = User::create(
            [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('admin123')
            ]
        );

        // Login created user
        Auth::login($user);

        // Impersonate the created user
        $this->actingAs($user)
            ->post('/logout')
          // ->post('/logout', ['_token' => csrf_token()])
            ->assertRedirectedTo('/');

        // Check if we're truly logged out
        $this->assertFalse(Auth::check());
    }

    /**
   * Test the User loggin in to the application.
   * Do so by creating a new mock user, visiting the login page, filling out
   * the users information and pressing the login button. If we see the
   * dashboard page we know we're in
   */
    public function testLogin()
    {
        $user = User::create(
            [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('admin123')
            ]
        );

        $this->visit('/login')
            ->type('johndoe@example.com', 'email')
            ->type('admin123', 'password')
            ->press('Login')
            ->seePageIs('/dashboard');
    }

}
