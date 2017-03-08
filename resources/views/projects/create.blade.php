@extends('layouts.master')
@section('title', 'Nieuw Project')
@section('content')

    {{-- BreadCrumbs --}}
    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/projects">Projecten</a></li>
        <li class="active">Nieuw Project</li>
    </ol>

    {{-- Page Title --}}
    <h1>Nieuw Project</h1>

    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1 col-sm-offset-0">
            {!! Form::open(['route' => ['projects.store'], 'method'=>'POST']) !!}

            @include('projects.partials_create.form')

            {!! Form::submit('Opslaan', array('class'=>'btn btn-success')) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection