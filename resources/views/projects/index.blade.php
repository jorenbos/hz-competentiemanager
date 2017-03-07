@extends('layouts.master')

@section('title', 'Projecten')

@section('content')

    {{-- BreadCrumbs --}}
    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Projecten</li>
    </ol>

    {{-- Page Title --}}
    <h1>Projecten</h1>

    {{-- Content --}}
    <table class="table">
        <thead>
            <tr>
                <td>Naam</td>
                <td>Projectnummer</td>
                <td>Contactpersoon</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)

                <tr>
                    <td>{{$project->name}}</td>
                    <td>{{$project->projectnumber}}</td>
                    <td>-</td>
                    <td>
                        <a href="{{ url('/projects') }}"
                           class="btn btn-danger pull-right" 
                           onclick="event.preventDefault();
                                    document.getElementById('delete-form-{{$project->id}}').submit();">
                            Verwijderen
                        </a>
                        <form id="delete-form-{{$project->id}}" action="{{ url("/projects/$project->id") }}" method="DELETE" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                        <a href="/projects/{{$project->id}}/edit" class="btn btn-primary pull-right">Bewerken</a>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

@endsection