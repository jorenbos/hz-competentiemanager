@extends('layouts.master')

@section('title')
{{ $competency->name }}
@endsection
@section('content')
<table class="table">
	<thead>
		<th>ID</th>
		<th>Naam</th>
		<th>EC Waarde</th>
	</thead>
	<tbody>
		<tr
			data-href="{{action('CompetencyController@show', ['id' => $competency->id]) }}">
			<td>{{ $competency->id }}</td>
			<td>{{ $competency->name }}</td>
			<td>{{ $competency->ec_value }}</td>
		</tr>
	</tbody>
</table>
@endsection
