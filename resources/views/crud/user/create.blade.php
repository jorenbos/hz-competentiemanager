@extends('layouts.app')

@section('title','Nieuwe Gebruiker')

@section('content')

    <div class="col-md-6 col-md-offset-3">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif


        <form action="{{url('/users')}}" method="post">
            {{csrf_field()}}

            <div class="form-group">
                <label for="email">Email adres</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="name">Naam</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Naam">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Wachtwoord</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                       placeholder="Wachtwoord">
            </div>

            <input class="btn btn-success" type="submit" value="Maak">
        </form>

    </div>

@endsection