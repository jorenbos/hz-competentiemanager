<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCredentials;
use Illuminate\Http\Request;

class UserCredentialsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()
            ->json(UserCredentials::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
            'name' => 'required|max:255',
            'student_code' => 'required|max:8|unique:user_credentials',
            'date_of_birth' => 'sometimes|date',
            'starting_year' => 'sometimes|date',
            'gender' => 'sometimes|max:10'
            ]
        );

        if ($validator->fails()) {
            return response()
                ->json($validator->messages(), 422);
        }

        $userCredentials = UserCredentials::create($request->all());

        return response()
            ->json($userCredentials);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()
            ->json(UserCredentials::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = \Validator::make(
            $request->all(), [
            'name' => 'required|max:255',
            'student_code' => 'required|max:8|unique:user_credentials',
            'date_of_birth' => 'sometimes|date',
            'starting_date' => 'sometimes|date',
            'gender' => 'sometimes|max:10'
            ]
        );

        if ($validator->fails()) {
            return response()
                ->json($validator->messages(), 422);
        }

        $userCredentials = UserCredentials::findOrFail($id)->change($request->all());

        return response()
            ->json($userCredentials);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserCredentials::destroy($id);

        return response()
            ->json([], 200);
    }
}
