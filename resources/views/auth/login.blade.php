@extends('layouts.main')

@section('title','Login')

@section('content')
<div class="container col-md-4 col-md-offset-4">

      @if($errors->any())
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      @endif

      <form method="POST" class="form-signin">
        {{ csrf_field() }}
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Email address" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

</div>
@endsection
