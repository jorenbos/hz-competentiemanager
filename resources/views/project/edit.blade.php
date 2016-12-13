@extends('layouts.app')

@section('title')
	Bewerk {{ $project->name }}
@endsection

@section('content')
<div class='container-fluid'>
	<div class='row'>
		<div class='col-md-8'>
		{!! Form::model($project, ['route' => ['project.update', $project->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}

<!--Fillable form which needs a name for the project being edited-->
			<div class="form-group">
					<div class="col-md-8">
						{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
						{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Projectnaam']) !!}
					</div>
			</div>

<!--Fillable form which needs a projectnumber for the project being edited-->
			<div class="form-group">
					<div class="col-md-8">
						{!! Form::label('projectnumber', 'Projectnumber', ['class' => 'control-label']) !!}
						{!! Form::text('projectnumber', null, ['class' => 'form-control', 'placeholder' => 'Projectnummer']) !!}
					</div>
			</div>

<!--Fillable form which needs a description for the project being edited-->
			<div class="form-group">
					<div class="col-md-8">
						{!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
						{!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Project beschrijving']) !!}
					</div>
			</div>

<!--This button save the edited project by calling upon the update method in the ProjectController-->
			<div class="form-group">
				<div class="col-md-8">
					<button type="submit" class="btn btn-primary">
						Opslaan
					</button>
				</div>
			</div>

		</div>
	</div>
</div>
{!! Form::close() !!}

@endsection
