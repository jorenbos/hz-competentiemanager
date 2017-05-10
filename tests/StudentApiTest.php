<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class StudentApiTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        \App\Models\Student::create(
            [
            'name'         => 'John Doe',
            'student_code' => '00038574',
            'date_of_birth' => '1996-11-11',
            'starting_date' => '2011-09-01',
            ]
        );
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStudentList()
    {
        $this->visit('api/student')
            ->seeJson(['name' =>'John Doe']);
    }

    public function testStudentShow()
    {
        $this->visit('api/student/1')
            ->seeJson(['name' =>'John Doe']);
    }

    public function testStudentCreate()
    {
        $this->json(
            'POST', 'api/student', [
            'name'          => 'Co de Klopper',
            'student_code'  => '00055976',
            'gender'        => 'man',
            'date_of_birth' => '1996-11-11',
            'starting_date' => '2011-09-01',
            ]
        )->seeJson(['name' => 'Co de Klopper']);

        // If we do this again it should fail because of duplicate student_code
        $this->json(
            'POST', 'api/student', [
            'name'          => 'Co de Klopper',
            'student_code'  => '00055976',
            'gender'        => 'man',
            'date_of_birth' => '1996-11-11',
            'starting_date' => '2011-09-01',
            ]
        )->seeJson(['student_code' => ['The student code has already been taken.']]);
    }
}
