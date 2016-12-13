<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view ( 'user/index', [
          'users' => User::orderBy ( 'name', 'asc' )->get (),
      ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ( 'user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Check if the form was correctly filled in
    $this->validate ( $request, [
        'name' => 'required|max:255',
    ] );
    // Create new Location object with the info in the request
    $user = User::create ( [
        'name' => $request ['name'],
    ] );
    // Save this object in the database
    $user->save ();
    // Redirect to the location.index page with a success message.
    return redirect ( 'user' )->with( 'success', $user->name.' is toegevoegd.' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return view ( 'user/show', [
        'user' => User::findOrFail($id),
      ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return view ( 'user/edit', [
         'user' => User::findOrFail($id)
       ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      echo 'update';
              // Check if the form was correctly filled in
              $this->validate ( $request, [
                  'name' => 'required|max:255',
                  'email' => 'required|max:255',
              ] );

              $user = User::findorfail ( $id );
              $user->name = $request ['name'];
              $user->email = $request ['email'];

              // Save the changes in the database
              $user->save ();

              // Redirect to the user.index page with a success message.
              return redirect ( 'user' )->with( 'success', $user->name.' is bijgewerkt.' );
              //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail ($id);
      $user->delete();
      return redirect ('user');
    }
}
