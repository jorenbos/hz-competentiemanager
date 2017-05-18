<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Validator;
use View;

class ProjectController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $projects;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projects = $projectRepository;
    }

    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'project.index',
            [
             'projects' => $this->projects->getAll(),
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
        return view('project.create');
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
            return redirect('/project/create')->withErrors($validator)->withInput();
        }

        $this->projects->create($request->all());

        return redirect('/project/create')->with(['status' => 'Project Aangemaakt']);
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
            'project.show',
            [
             'project' => $this->projects->getById($id),
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
            'project.edit',
            [
             'project' => $this->projects->getById($id),
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
        echo 'update';
              // Check if the form was correctly filled in
              $this->validate(
                  $request,
                  [
                   'name'          => 'required|max:255',
                   'projectnumber' => 'required|max:255',
                   'description'   => 'required|max:255',
                  ]
              );

        $project = $this->projects->getById($id);
        $project->name = $request['name'];
        $project->projectnumber = $request['projectnumber'];

        // Save the changes in the database
        $project->save();
        // Redirect to the project.index page with a success message.
        return redirect('project')->with(['status' => "$project->name is bijgewerkt"]);
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
        $project = $this->projects->getById($id);
        $project->delete();

        return redirect('project')->with(['status' => "$project->name is verwijderd"]);
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
