@extends('layouts.app')

@section('title','Gebruikers')


@section('content')

    @if (session('status'))
        <div class="col-lg-8 col-lg-offset-2">
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <div class="col-lg-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Naam</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->email }}</td>
                    <td><a href="{{url("/users/$user->id")}}">{{ $user->name }}</a></td>
                    <td>
                        <div class="input-group" role="group" aria-label="...">
                            <span class="input-group-btn">
                                <a class="btn btn-sm btn-default" href="{{url("/users/$user->id/edit")}}">Bewerk</a>
                            </span>
                            <form action="{{url("/users/$user->id")}}" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                {{csrf_field()}}
                                <span class="input-group-btn">
                                    <input type="submit" class="btn btn-sm btn-danger" value="Verwijder">
                                </span>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
