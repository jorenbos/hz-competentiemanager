@extends('layouts.main')

@section('title','Register account')

@section('content')
<div class="container col-md-4 col-md-offset-4">

  @if($errors->any())
    @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
  @endif

  <form method="POST" class="form-signin">
    {{ csrf_field() }}
    <h2 class="form-signin-heading">Register new account</h2>
    <label for="inputName" class="sr-only">Name</label>
    <input type="text" id="name" name="name" class="form-control" placeholder="Name" required="" autofocus="">
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
    <label for="repeatPassword" class="sr-only">Confirm password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required="">
    <div class="checkbox">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
  </form>

</div>
@endsection
