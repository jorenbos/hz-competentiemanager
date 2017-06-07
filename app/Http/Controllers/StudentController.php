<?php

namespace App\Http\Controllers;

use App\Repositories\StudentRepository;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }
    public function index()
    {
        return view(
            'students.index',
            [
                'students' => $this->studentRepository->getAll()
            ]
        );
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        // Create new Competency object with the info in the request
        $student = $this->studentRepository->create($request->all());

        // Redirect to the competency.index page with a success message.
        return redirect('students')->with('success', $student->name.' is toegevoegd.');
    }

    public function show($id)
    {
        return view(
            'students.show',
            [
             'students' => $this->studentRepository->getById($id),
            ]
        );
    }

    public function edit($id)
    {
        return view(
            'students.edit',
            [
             'students' => $this->studentRepository->getById($id),
            ]
        );
    }

    public function update(Request $request, $id)
    {

        $this->studentRepository->update($request->all(), $id);


        // Redirect to the competency.index page with a success message.
        return redirect('students')->with('success', $request['name'].' is bijgewerkt.');
    }

    public function destroy($id)
    {
        // Find the competency object in the database
        $student = $this->studentRepository->getById($id);

        // Remove the competency from the database
        $student->delete();

        // Redirect to the competency. index page with a succes message.
        return redirect('students')->with('success', $student->name.' is verwijderd.');
    }
}
