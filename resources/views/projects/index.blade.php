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

    {{-- Create Button --}}
    <a href="/projects/create" class="btn btn-primary pull-right">Project Toevoegen</a>

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
                    <td>{{$project->contact->name}}</td>
                    <td>
                        {!! Form::open(['route' => ['projects.destroy', $project->id], 'method'=>'DELETE']) !!}
                        {!! Form::submit('Verwijderen', array('class'=>'btn btn-danger pull-right')) !!}
                        {!! Form::close() !!}

                        <a href="/projects/{{$project->id}}/edit" class="btn btn-primary pull-right">Bewerken</a>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

@endsection