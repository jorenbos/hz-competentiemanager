<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCompetenciesController extends Controller
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($student)
    {
        $allStudents = $this->studentRepository->getAll();
        $competencies = $this->studentRepository->getUncompletedCompetencies($this->studentRepository->getById($student));
        return view(
            'user_competencies.index',
            [
             'comps' => $competencies,
             'students' => $allStudents,
             'current'  => $student
            ]
        );
    }

    public function store(Request $request)
    {
        $this->studentRepository->getById(Auth::id())->competencies()->attach($request['comp_id'], ['status' => 2 ]);
        return redirect('/student/'.$request['student'] . 'competencies')->with('success', 'Uw competentie is gekozen');
    }
}
