@extends('layouts.app')

@section('title')
<div class="row">
	<div class="col-sm-10">
			({{$competency->id}}) {{$competency->name}}
	</div>
	<div class="col-sm-1">
		 <a class="btn btn-default" href="{{action('CompetencyController@edit', $competency->id)}}">Bewerken</a>
	</div>
	<div class="col-sm-1">
			{!! Form::open(['route' => ['competency.destroy', $competency->id], 'method'=>'DELETE']) !!}
			{!! Form::submit('Verwijderen', array('class'=>'btn btn-danger')) !!}
			{!! Form::close() !!}
	</div>
</div>
@endsection

@section('content')
<table class="table table-striped table-hover">
	<thead>
		<th class="col-sm-1">ID</th>
		<th class="col-sm-4">Naam</th>
	</thead>
	<tbody>
		<tr class="row-link" style="cursor: pointer;"
			data-href="{{action('CompetencyController@show', ['id' => $competency->id]) }}">
			<td class="table-text">{{ $competency->id }}</td>
			<td class="table-text">{{ $competency->name }}</td>
		</tr>
	</tbody>
</table>
@endsection
