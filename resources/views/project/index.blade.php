@extends('layouts.app')

@section('title')
	Lijst van competenties

@endsection

@section('content')
<div style="float:left">
	<a class="btn btn-primary" href="{!! url('project/create') !!}">
		Project toevoegen
	</a>
</div>
<div style="float:left">
	<a class="btn btn-primary" href="{!! url('project/edit') !!}">
		Project wijzigen
	</a>
</div>
<div style="float:left">
	<a class="btn btn-primary" href="{!! url('project/show') !!}">
		Alle projecten weergeven
	</a>
</div>
	@if (count($projecten) > 0)
		<table class="table table-striped table-hover">
			<thead>
				<th class="col-sm-1">Id</th>
				<th class="col-sm-4">Naam</th>

			</thead>
			<tbody>
				@foreach ($projecten as $project)
				<tr class="row-link" style="cursor: pointer;"
					data-href="{{action('ProjectController@show', ['id' => $project->id]) }}">
					<td class="table-text">{{ $project->id }}</td>
					<td class="table-text">{{ $project->name}}</td>

					<td class="table-text">
						<div>
							<a class="btn btn-primary" href="{!! url('project/' . $project->id .'/edit' ) !!}">
								Project wijzigen
							</a>
						</div>
					</td>

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
