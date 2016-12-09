<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCrudTest extends TestCase
{

    use DatabaseMigrations;



    /**
     * A basic test example.
     *
     * @return void
     */
    public function testList()
    {
        $this->mockSomeUsers();

        $this->visit('/users')
            ->see('John Doe')
            ->see('Jane Doe');
    }

    public function testShow()
    {
        $this->mockSomeUsers();

        $this->visit('/users/1')
            ->see('where we');
    }

    public function testEdit()
    {
        $this->mockSomeUsers();

        $this->visit('/users/1/edit')
            ->see('John Doe');
    }

    /**
     * FIXME The update method is broken by design as of now, this test will have to be rewritten
     */
    public function testUpdate()
    {
        $this->mockSomeUsers();

        $this->visit('/users/1/edit')
            ->type('Meme','name')
            ->press('Opslaan')
            ->see('Meme');

        $this->visit('/users/1/edit')
            ->see('Meme');
    }

    public function testCreate()
    {

    }

    private function mockSomeUsers()
    {
        User::create(
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => bcrypt('admin123')
            ]
        );
        User::create(
            [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'password' => bcrypt('admin123')
            ]
        );
        User::create(
            [
                'name' => 'Jimmy Woo',
                'email' => 'jimmy@example.com',
                'password' => bcrypt('admin123')
            ]
        );
    }
}
