<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Validator;
use View;

class ProjectController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $projects;

    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(ProjectRepository $projectRepository, UserRepository $userRepository)
    {
        $this->projects = $projectRepository;
        $this->users = $userRepository;
    }

    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'projects.index',
            [
             'projects' => $this->projects->findAll(),
            ]
        );
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create', [
            'users' => $this->users->findAll(),
        ]);
    }

    /**
     * Store a newly created project in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect('/projects/create')->withErrors($validator)->withInput();
        }

        $this->projects->create($request->all());

        return redirect('/projects')->with(['status' => 'Project Aangemaakt']);
    }

    /**
     * Display the specified project.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view(
            'projects.show',
            [
             'project' => $this->projects->find($id),
            ]
        );
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view(
            'projects.edit',
            [
             'project' => $this->projects->find($id),
            ]
        );
    }

    /**
     * Update the specified project in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check if the form was correctly filled in
              $this->validate(
                  $request,
                  [
                   'name'          => 'required|max:255',
                   'projectnumber' => 'required|max:255',
                   'description'   => 'required|max:255',
                  ]
              );

        $project = $this->projects->find($id);
        $project->name = $request['name'];
        $project->projectnumber = $request['projectnumber'];

        // Save the changes in the database
        $project->save();
        // Redirect to the project.index page with a success message.
        return redirect('projects')->with(['status' => "$project->name is bijgewerkt"]);
    }

    /**
     * Remove the specified project from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->projects->delete($id);

        return redirect('projects')->with(['status' => "$project->name is verwijderd"]);
    }

    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
             'name'          => 'required|max:255',
             'projectnumber' => 'required|max:255',
             'description'   => 'required|min:6',
            ]
        );
    }
}
