@extends('layouts.app')

@section('title')
	Bewerk {{ $user->name }}
@endsection

@section('content')
<div class='container-fluid'>
	<div class='row'; style='align: right'>
		<div class='col-md-8'>
		<div class='col-md-8'>
		{!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}

<!--Fillable form for the username that needs editing-->
			<div class="form-group">
					<div class="col-md-8">
						{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
						{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Gebruikersnaam']) !!}
					</div>
			</div>

<!--Fillable form for the email of the user that is being edited-->
			<div class="form-group">
					<div class="col-md-8">
						{!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
						{!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
					</div>
			</div>

<!--This button will redirect the user to the /user page after the edited info has been saved in the database-->
			<div class="form-group">
				<div class="col-md-8">
					<button type="submit" class="btn btn-primary">
						Opslaan
					</button>
				</div>
			</div>

		</div>
</div>
{!! Form::close() !!}

@endsection
