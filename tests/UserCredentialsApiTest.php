<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCredentialsApiTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        \App\Models\UserCredentials::create([
            'name' => 'John Doe',
            'student_code' => '00038574'
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCredentialsList()
    {
        $this->visit('api/usercredentials')
            ->seeJson(['name' =>'John Doe']);
    }

    public function testUserCredentialsShow()
    {
        $this->visit('api/usercredentials/1')
            ->seeJson(['name' =>'John Doe']);
    }

    public function testUserCredentialsCreate()
    {
        $this->json('POST', 'api/usercredentials', [
            'name' => 'Co de Klopper',
            'student_code' => '00055976',
            'gender' => 'man',
            'date_of_birth' => '1996-11-11',
            'starting_date' => '2011-09-01'
        ])->seeJson(['name' => 'Co de Klopper']);

        // If we do this again it should fail because of duplicate student_code
        $this->json('POST', 'api/usercredentials', [
            'name' => 'Co de Klopper',
            'student_code' => '00055976',
            'gender' => 'man',
            'date_of_birth' => '1996-11-11',
            'starting_date' => '2011-09-01'
        ])->seeJson(['student_code' => ['The student code has already been taken.']]);
    }
}
