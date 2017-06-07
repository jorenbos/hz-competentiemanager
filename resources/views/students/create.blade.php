@extends('layouts.master')

@section('title')
	Voeg een student toe
@endsection

@section('tools')
<li role="navigation">
	<a onClick="window.history.back()">
		<i class="fa fa-arrow-left"></i>&nbsp;Terug
	</a>
</li>
@endsection


@section('content')
{!! Form::open(['route' => ['students.store'], 'method' => 'post', 'class' => 'form-horizontal']) !!}
<!-- Holds all the forms for filling in student info-->
<div class="form-group">
	<!-- A form for filling in the name of the project-->
	<div class="col-sm-6">
		{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
		{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Naam']) !!}
	</div>
	<!-- A form for filling in the abbreviation of the project-->
	<div class="col-sm-6">
		{!! Form::label('student_code', 'Student Code', ['class' => 'control-label']) !!}
		{!! Form::text('student_code', null, ['class' => 'form-control', 'placeholder' => 'Student Code']) !!}
	</div>
	<!-- A form for filling in the description of the project-->
	<div class="col-sm-6">
		{!! Form::label('date_of_birth', 'Geboorte Datum', ['class' => 'control-label']) !!}
		{!! Form::date('date_of_birth', null, ['class' => 'form-control', 'placeholder' => 'Geboorte Datum']) !!}
	</div>
	<!-- A form for filling in the EC-value of the project-->
	<div class="col-sm-6">
		{!! Form::label('starting_date', 'Begin datum', ['class' => 'control-label']) !!}
		{!! Form::date('starting_date', null, ['class' => 'form-control', 'placeholder' => 'Begin Datum']) !!}
	</div>
	<!-- A form for filling in the CU-code of the project-->
	<div class="col-sm-6">
		<label class='control-label' for="gender">Gender</label>
        <select class="form-control" id="gender" name='gender'>
            <option value='male'>Male</option>
			<option value='female'>Female</option>

        </select>
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
