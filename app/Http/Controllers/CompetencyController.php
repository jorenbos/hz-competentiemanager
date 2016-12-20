<?php

namespace App\Http\Controllers;

use App\Repositories\CompetencyRepository;
use Validator;
use View;
use Illuminate\Http\Request;
use App\Models\Competency;

class CompetencyController extends Controller
{
    /**
     * @var CompetencyRepository
     */

    private $competencies;

    public function __construct(CompetencyRepository $CompetencyRepository)
    {
        $this->competency = $CompetencyRepository;
    }
    /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index()
    {

        return view(
            'competency.index', [
            'competenties' => $this->competency->getAll(),
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

        return view('competency.create');

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
        $validator = $this->validator($request->all());

        if($validator->fails()) {
            return redirect('/competency/create')
                ->withErrors($validator)
                ->withInput();
        }

        // Create new Competency object with the info in the request
        $competency = $this->competency->create(
            [
                'name' => $request['name'],
                'abbreviation' => $request['abbreviation'],
                'description' => $request['description'],
                'ec_value' => $request['EC-value'],
                'cu_code' => $request['CU-code']
            ]
        );
        // Save this object in the database
        //$competency->save();
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
            'competency' => $this->competency->getById($id),
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
            'competency' => $this->competency->getById($id),
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

        //echo 'update';
        // Check if the form was correctly filled in
        // Check if the form was correctly filled in
        $validator = $this->validator($request->all());

        if($validator->fails()) {
            return redirect('/competency')
                ->withErrors($validator)
                ->withInput();
        }

        $this->competency->update(
            [
            'name' => $request['name'],
            'abbreviation' => $request['abbreviation'],
            'description' => $request['description'],
            'ec_value' => $request['EC-value'],
            'cu_code' => $request['CU-code']
        ], $id);

        // Redirect to the competency.index page with a success message.
        return redirect('competency')->with('success', $request['name'].' is bijgewerkt.');

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

    protected function validator($data) {
        return Validator::make(
            $data, [
                'name' => 'required|max:255',
                'abbreviation' => 'required|max:5',
                'description' => 'required|max:2056',
                'EC-value' => 'required',
                'CU-code' => 'required|max:10'
            ]
        );
    }
}
