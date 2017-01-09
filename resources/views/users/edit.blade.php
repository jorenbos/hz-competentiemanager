@extends('layouts.app')

@section('title','Bewerk '. $user->name)

@section('content')

    <div class="col-md-6 col-md-offset-3">
        @include('includes.status-errors')

        <form method="post" action="{{url("/users/$user->id")}}">
            <input type="hidden" name="_method" value="PUT">
            @include('users.partials.baseform')
            <input class="btn btn-success" type="submit" value="Opslaan">
        </form>

    </div>



    @endsection
