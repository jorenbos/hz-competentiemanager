<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competency;

class CompetencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view(
            'competency/index', [
            'competenties' => Competency::orderBy('name', 'asc')->get(),
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

        return view('competency/create');

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
        // Create new Competency object with the info in the request
        $competency = Competency::create(
            [
            'name' => $request ['name'],
             ]
        );
        // Save this object in the database
        $competency->save();
        // Redirect to the competency.index page with a success message.
        return redirect('competency')->with('success', $competency->name.' is toegevoegd.');

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
            'competency/show', [
            'competency' => Competency::findOrFail($id),
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
            'competency/edit', [
            'competency' => Competency::findOrFail($id),
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
            'abbreviation' => 'required|max:255',
            'description' => 'required|max:255',
            'EC-value' => 'required|max:255',
            'CU-code' => 'required|max:255',
             ]
        );

        $competency = Competency::findorfail($id);
        $competency->name = $request ['name'];
        $competency->abbreviation = $request ['abbreviation'];
        $competency->description = $request ['description'];
      //  $competency->EC-value = $request ['EC-value'];
      //  $competency->CU-code = $request ['CU-code'];

        // Save the changes in the database
        $competency->save();

        // Redirect to the competency.index page with a success message.
        return redirect('competency')->with('success', $competency->name. '  is bijgewerkt.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find the competency object in the database
        $competency = Competency::findorfail($id);
        //Remove the competency from the database
        $competency->delete();
        //Redirect to the competency. index page with a succes message.
        return redirect('competency')->with('success', $competency->name.' is verwijderd.');
    }
}
