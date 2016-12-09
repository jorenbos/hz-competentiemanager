<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Validator;
use View;
use Illuminate\Http\Request;

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
        return \View::make('crud.user.list', ['users' => $this->users->getAll()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('crud.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if($validator->fails()){
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('crud.user.show',['user' => $this->users->getById($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return View::make('crud.user.edit',['user' => $this->users->getById($id)]);
    }

    /**
     * Update the specified resource in storage.
     * FIXME This doesn't validate at all, we might actually want to rewrite this whole thing
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->users->getById($id);
        $user->fill($request->all());
        $user->save();

        return redirect("/users/$id/edit")->with(['status' => 'Gebruiker aangepast']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->users->delete($id);
        return redirect('/users')->with('status', 'Gebruiker Verwijderd!');
    }

    protected function updateValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'sometimes|max:255',
            'email' => 'sometimes|email|max:255|unique:users',
            'password' => 'sometimes|min:6',
        ]);
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
