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
        $this->competencies = $CompetencyRepository;

    }//end __construct()


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'competency.index',
            [
             'competenties' => $this->competencies->getAll(),
            ]
        );

    }//end index()


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('competency.create');

    }//end create()


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if the form was correctly filled in
        $validator = $this->storeValidator($request->all());

        if ($validator->fails()) {
            return redirect('/competency/create')->withErrors($validator)->withInput();
        }

        // Create new Competency object with the info in the request
        $competency = $this->competencies->create($request->all());

        // Redirect to the competency.index page with a success message.
        return redirect('competency')->with('success', $competency->name.' is toegevoegd.');

    }//end store()


    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view(
            'competency/show',
            [
             'competency' => $this->competencies->getById($id),
            ]
        );

    }//end show()


    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view(
            'competency/edit',
            [
             'competency' => $this->competencies->getById($id),
            ]
        );

    }//end edit()


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer                  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check if the form was correctly filled in
        $validator = $this->updateValidator($request->all());

        if ($validator->fails()) {
            return redirect('/competency')->withErrors($validator)->withInput();
        }

        $this->competencies->update($request->all(), $id);

        // Redirect to the competency.index page with a success message.
        return redirect('competency')->with('success', $request['name'].' is bijgewerkt.');

    }//end update()


    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the competency object in the database
        $competency = $this->competencies->getById($id);

        // Remove the competency from the database
        $competency->delete();

        // Redirect to the competency. index page with a succes message.
        return redirect('competency')->with('success', $competency->name.' is verwijderd.');

    }//end destroy()


    /**
     * Validator for form data when a store call is made.
     *
     * @param  array $data
     * @return \Validator
     */
    protected function storeValidator($data)
    {
        return Validator::make(
            $data,
            [
             'name'         => 'required|max:255',
             'abbreviation' => 'required|max:5|unique:competencies',
             'description'  => 'required|max:2056',
             'ec_value'     => 'required',
             'cu_code'      => 'required|max:10',
            ]
        );

    }//end storeValidator()


    /**
     * Validator for form data when a update call is made.
     *
     * @param  array $data
     * @return \Validator
     */
    protected function updateValidator($data)
    {
        return Validator::make(
            $data,
            [
             'name'         => 'required|max:255',
             'abbreviation' => 'required|max:5',
             'description'  => 'required|max:2056',
             'ec_value'     => 'required',
             'cu_code'      => 'required|max:10',
            ]
        );

    }//end updateValidator()


}//end class
