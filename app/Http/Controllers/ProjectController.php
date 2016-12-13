<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'project/index', [
            'projects' => Project::orderBy('name', 'asc')->get(),
             ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if the form was correctly filled in
        $this->validate(
            $request, [
            'name' => 'required|max:255',
             ]
        );
        // Create new Location object with the info in the request
        $project = Project::create(
            [
            'name' => $request ['name'],
             ]
        );
        // Save this object in the database
        $project->save();
        // Redirect to the location.index page with a success message.
        return redirect('project')->with('success', $project->name.' is toegevoegd.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view(
            'project/show', [
            'project' => Project::findOrFail($id),
             ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view(
            'project/edit', [
            'project' => Project::findOrFail($id)
             ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo 'update';
              // Check if the form was correctly filled in
              $this->validate(
                  $request, [
                  'name' => 'required|max:255',
                  'projectnumber' => 'required|max:255',
                  'description' => 'required|max:255',
                   ]
              );

              $project = Project::findorfail($id);
              $project->name = $request ['name'];
              $project->projectnumber = $request ['projectnumber'];

              // Save the changes in the database
              $project->save();

              // Redirect to the project.index page with a success message.
              return redirect('project')->with('success', $project->name.' is bijgewerkt.');
              //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect('project');
    }
}
