@extends('layouts.app')

@section('title')
	Voeg een project toe
@endsection

@section('tools')
<li role="navigation">
	<a onClick="window.history.back()">
		<i class="fa fa-arrow-left"></i>&nbspTerug
	</a>
</li>
@endsection

@section('content')
<div class="col-md-6 col-md-offset-3">
		@include('includes.status-errors')

<!--Container with the page content -->
<div class='container-fluid'>
{!! Form::open(['route' => ['project.store'], 'method' => 'post', 'class' => 'form-horizontal']) !!}

<!--Container for the fillable fields -->
<div class="form-group">

	<!--Fillable form which needs a name for the project being added -->
	<div class="col-md-6">
		{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
		{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Projectnaam']) !!}
	</div>

	<!--Fillable form which needs a number for the project being added -->
	<div class="col-md-6">
		{!! Form::label('projectnumber', 'Projectnumber', ['class' => 'control-label']) !!}
		{!! Form::text('projectnumber', null, ['class' => 'form-control', 'placeholder' => 'Projectnummer']) !!}
	</div>

	<!--Fillable form which needs a description for the project being added -->
	<div class="col-md-6">
		{!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
		{!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Beschrijving']) !!}
	</div>

</div>

<!--This button uses the create method in the ProjectController-->
				<div class="form-group">
					<div class="col-md-6">
						<button type="submit" class="btn btn-primary">
							Opslaan
						</button>
					</div>
				</div>
			</div>
{!! Form::close() !!}
@endsection
