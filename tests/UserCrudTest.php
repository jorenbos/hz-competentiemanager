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
    public function testIndex()
    {
        $this->mockSomeUsers();

        $this->visit('/user')
            ->see('John Doe')
            ->see('Jane Doe');
    }

    public function testShow()
    {
        $this->mockSomeUsers();

        $this->visit('/user/1')
            ->see('John Doe')
            ->see('johndoe@example.com');
    }

    public function testEdit()
    {
        $this->mockSomeUsers();

        $this->visit('/user/1/edit')
            ->see('John Doe');
    }

    /**
     * FIXME The update method is broken by design as of now, this test will have to be rewritten.
     */
    public function testUpdate()
    {
        $this->mockSomeUsers();

        $this->visit('/user/1/edit')
            ->type('Meme', 'name')
            ->press('Opslaan')
            ->see('Gebruiker aangepast')
            ->see('Meme');

        $this->visit('/user/1/edit')
            ->see('Meme');
    }

    public function testCreate()
    {
        //Positive test
        $this->visit('user/create')
            ->type('hans@kpnplanet.nl', 'email')
            ->type('Hans', 'name')
            ->type('admin123', 'password')
            ->press('Maak')
            ->see('Gebruiker Aangemaakt')
            ->visit('/user')
            ->see('Hans');

        //Negative test, do not create users and break validation
        $this->visit('user/create')
            ->type('hans@kpnplanet', 'email')
            ->type('Hans', 'name')
            ->type('admin', 'password')
            ->press('Maak')
            ->see('6 characters')
            ->see('valid');
    }

    public function testDelete()
    {
        User::create(
            [
                'name'     => 'John Doe',
                'email'    => 'johndoe@example.com',
                'password' => bcrypt('admin123'),
            ]
        );

        $this->visit('/user')
            ->see('John Doe');

        $this->visit('/user')
            ->press('Verwijder')
            ->dontSee('John Doe');
    }

    private function mockSomeUsers()
    {
        User::create(
            [
                'name'     => 'John Doe',
                'email'    => 'johndoe@example.com',
                'password' => bcrypt('admin123'),
            ]
        );
        User::create(
            [
                'name'     => 'Jane Doe',
                'email'    => 'jane@example.com',
                'password' => bcrypt('admin123'),
            ]
        );
        User::create(
            [
                'name'     => 'Jimmy Woo',
                'email'    => 'jimmy@example.com',
                'password' => bcrypt('admin123'),
            ]
        );
    }
}
