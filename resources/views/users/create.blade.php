@extends('layouts.app')

@section('title','Nieuwe Gebruiker')

@section('content')

    <div class="col-md-6 col-md-offset-3">
        @include('includes.status-errors')

        <form action="{{url('/user')}}" method="post">
            @include('users.partials.baseform')
            <input class="btn btn-success" type="submit" value="Maak">
        </form>

    </div>

@endsection
