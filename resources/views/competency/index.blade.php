@extends('layouts.app')

@section('title')
	Lijst van competenties
	<div style="float:right">
		<a class="btn btn-primary" href="{!! url('competency/create') !!}">
			Toevoegen
		</a>
	</div>
@endsection

@section('content')
	@if (count($competenties) > 0)
		<table class="table table-striped table-hover">
			<thead>
				<th class="col-sm-1">Id</th>
				<th class="col-sm-4">Naam</th>

			</thead>
			<tbody>
				@foreach ($competenties as $competency)
				<tr class="row-link" style="cursor: pointer;"
					data-href="{{action('CompetencyController@show', ['id' => $competency->id]) }}">
					<td class="table-text">{{ $competency->id }}</td>
					<td class="table-text">{{ $competency->name}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@endsection
@section('scripts')
<script>
	jQuery(document).ready(function($) {
	    $(".row-link").click(function() {
	        window.document.competency = $(this).data("href");
	    });
	    $('#cohort-tabs a:first').tab('show') // Select first tab
	});
</script>
@endsection
