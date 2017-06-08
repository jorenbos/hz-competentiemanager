@extends('layouts.master')
@section('title', 'Studenten')
@section('content')
    {{-- BreadCrumbs --}}
    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Studenten</li>
    </ol>

    {{-- Page Title --}}
    <h1>Studenten</h1>

    {{-- Create Button --}}
    <a href="students/create" class="btn btn-primary pull-right">Student Toevoegen</a>


    @if (count($students) > 0)
    <!-- Shows ID of item in database and name-->
        <table class="table">
            <thead>
                <th>Id</th>
                <th>Naam</th>

            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr data-href="{{action('StudentController@show', ['id' => $student->id]) }}">
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name}}</td>
                    <td>
                        <div>
                            <a class="btn btn-primary" href="{!! url('students/' . $student->id .'/edit' ) !!}">
                                Student wijzigen
                            </a>
                        </div>
                    </td>

                    <td class="table-text">
                        <div class="col-sm-1">
                            {!! Form::open(['route' => ['students.destroy', $student->id], 'method'=>'DELETE']) !!}
                            {!! Form::submit('Verwijderen', array('class'=>'btn btn-danger')) !!}
                            {!! Form::close() !!}
                        </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @endsection
