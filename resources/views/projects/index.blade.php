@extends('layouts.app')

@section('title')
	Lijst van competenties
	<div style="float:right">
		<a class="btn btn-primary" href="{!! url('project/create') !!}">
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
				@foreach ($competenties as $project)
				<tr class="row-link" style="cursor: pointer;"
					data-href="{{action('ProjectController@show', ['id' => $project->id]) }}">
					<td class="table-text">{{ $project->id }}</td>
					<td class="table-text">{{ $project->name}}</td>
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
	        window.document.project = $(this).data("href");
	    });
	    $('#cohort-tabs a:first').tab('show') // Select first tab
	});
</script>
@endsection
