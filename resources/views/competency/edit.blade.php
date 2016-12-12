@extends('layouts.app')

@section('title')
	Bewerk {{ $competency->name }}
@endsection

@section('content')
{!! Form::model($competency, ['route' => ['competency.update', $competency->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
<div class="form-group">
	<div class="form-group">
		<div class="col-sm-6">
			{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
			{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Naam']) !!}
		</div>
	</div>

	<div class="form-group">
		<div class="form-group">
			<div class="col-sm-6">
				{!! Form::label('abbreviation', 'Abbreviation', ['class' => 'control-label']) !!}
				{!! Form::text('abbreviation', null, ['class' => 'form-control', 'placeholder' => 'Afkorting']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="form-group">
				<div class="col-sm-6">
					{!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
					{!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Beschrijving']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="form-group">
					<div class="col-sm-6">
						{!! Form::label('EC-value', 'Ec-value', ['class' => 'control-label']) !!}
						{!! Form::text('EC-value', null, ['class' => 'form-control', 'placeholder' => 'Aantal ECs']) !!}
					</div>
				</div>

				<div class="form-group">
					<div class="form-group">
						<div class="col-sm-6">
							{!! Form::label('CU-code', 'Cu-code', ['class' => 'control-label']) !!}
					    {!! Form::text('CU-code', null, ['class' => 'form-control', 'placeholder' => 'CU code']) !!}
						</div>
					</div>

	<div class="form-group">
		<div class="col-sm-12">
			<button type="submit" class="btn btn-primary">
				Opslaan
			</button>
		</div>
	</div>

{!! Form::close() !!}

@endsection
