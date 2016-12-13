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

			<div class="form-group">
					<div class="col-md-8">
						{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
						{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Projectnaam']) !!}
					</div>
			</div>

			<div class="form-group">
					<div class="col-md-8">
						{!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
						{!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
					</div>
			</div>

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
