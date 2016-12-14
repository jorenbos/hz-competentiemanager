<?php

namespace App\Http\Controllers;


use App\Repositories\UserRepository;
use Validator;
use View;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            '/users/index', [
            'users' => User::orderBy('name', 'asc')->get(),
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
        return view('/users/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $validator = $this->validator($request->all());

        if($validator->fails()) {
            return redirect('/users/create')
                ->withErrors($validator)
                ->withInput();
        }
        $this->users->create($request->all());
        return redirect('/users/create')->with(['status' => 'Gebruiker Aangemaakt']);
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
            '/users/show', [
            'user' => User::findOrFail($id),
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
            '/users/edit', [
            'user' => User::findOrFail($id)
             ] 
        );
    }

    /**
     * Update the specified resource in storage.
     * FIXME This doesn't validate at all, we might actually want to rewrite this whole thing
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
                  'email' => 'required|max:255',
                   ] 
              );

              $user = User::findorfail($id);
              $user->name = $request ['name'];
              $user->email = $request ['email'];

              // Save the changes in the database
              $user->save();

              // Redirect to the user.index page with a success message.
              return redirect('/users')->with('success', $user->name.' is bijgewerkt.');
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
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/users');
    }

    protected function updateValidator(array $data)
    {
        return Validator::make(
            $data, [
            'name' => 'sometimes|max:255',
            'email' => 'sometimes|email|max:255|unique:users',
            'password' => 'sometimes|min:6',
            ]
        );
    }

    protected function validator(array $data)
    {
        return Validator::make(
            $data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
            ]
        );

    }
}
