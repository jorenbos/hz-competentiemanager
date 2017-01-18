<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\ProjectRepository;
use Validator;
use View;
use App\Models\Project;


class ProjectController extends Controller
{

    /**
     * @var ProjectRepository
     */
    private $projects;


    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projects = $projectRepository;

    }//end __construct()


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

    }//end index()


    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');

    }//end create()


    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request $request
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

    }//end store()


    /**
     * Display the specified project.
     *
     * @param  integer $id
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

    }//end show()


    /**
     * Show the form for editing the specified project.
     *
     * @param  integer $id
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

    }//end edit()


    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer                  $id
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

              $project                = $this->projects->getById($id);
              $project->name          = $request['name'];
              $project->projectnumber = $request['projectnumber'];

              // Save the changes in the database
              $project->save();

              // Redirect to the project.index page with a success message.
              return redirect('project')->with(['status' => "$project->name is bijgewerkt"]);

    }//end update()


    /**
     * Remove the specified project from storage.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = $this->projects->getById($id);
        $project->delete();
        return redirect('project')->with(['status' => "$project->name is verwijderd"]);

    }//end destroy()


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

    }//end validator()


}//end class
