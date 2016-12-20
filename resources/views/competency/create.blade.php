@extends('layouts.app')

@section('title')
	Voeg een competentie toe
@endsection

@section('tools')
<li role="navigation">
	<a onClick="window.history.back()">
		<i class="fa fa-arrow-left"></i>&nbspTerug
	</a>
</li>
@endsection

@include('includes.status-errors')

@section('content')
{!! Form::open(['route' => ['competency.store'], 'method' => 'post', 'class' => 'form-horizontal']) !!}
<!-- Holds all the forms for filling in competency info-->
<div class="form-group">
	<!-- A form for filling in the name of the project-->
	<div class="col-sm-6">
		{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
		{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Naam']) !!}
	</div>
	<!-- A form for filling in the abbreviation of the project-->
	<div class="col-sm-6">
		{!! Form::label('abbreviation', 'Abbreviation', ['class' => 'control-label']) !!}
		{!! Form::text('abbreviation', null, ['class' => 'form-control', 'placeholder' => 'Afkorting']) !!}
	</div>
	<!-- A form for filling in the description of the project-->
	<div class="col-sm-6">
		{!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
		{!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Beschrijving']) !!}
	</div>
	<!-- A form for filling in the EC-value of the project-->
	<div class="col-sm-6">
		{!! Form::label('EC-value', 'Ec-value', ['class' => 'control-label']) !!}
		{!! Form::text('EC-value', null, ['class' => 'form-control', 'placeholder' => 'Aantal ECs']) !!}
	</div>
	<!-- A form for filling in the CU-code of the project-->
  <div class="col-sm-6">
    {!! Form::label('CU-code', 'Cu-code', ['class' => 'control-label']) !!}
    {!! Form::text('CU-code', null, ['class' => 'form-control', 'placeholder' => 'CU code']) !!}
  </div>
</div>

<div class="form-group">
	<div class="col-sm-12">
		<!-- A button for saving made changes-->
		<button type="submit" class="btn btn-primary">
			Opslaan
		</button>
	</div>
</div>
{!! Form::close() !!}
@endsection
