@extends('layouts.app')

@section('title')
	Lijst van projecten

@endsection

@section('content')

<!--Button to add a new project, directs the user to the create page-->
<div style="float:left">
	<a class="btn btn-primary" href="{!! url('project/create') !!}">
		Project toevoegen
	</a>
</div>

<!--Table headers-->
	@if (count($projects) > 0)
		<table class="table table-striped table-hover">
			<thead>
				<th class="col-sm-1">Id</th>
				<th class="col-sm-4">Naam</th>
			</thead>

<!--Table will be filled with the projects present in the database-->
			<tbody>
				@foreach ($projects as $project)
				<tr class="row-link" style="cursor: pointer;"
									data-href="{{action('ProjectController@show', ['id' => $project->id]) }}">
					<td class="table-text">{{ $project->id }}</td>
					<td class="table-text">{{ $project->name}}</td>

<!--This button will redirect the user to the /project/edit page-->
					<td class="table-text">
						<div>
							<a class="btn btn-primary" href="{!! url('project/' . $project->id .'/edit' ) !!}">
								Wijzigen
							</a>
						</div>
					</td>

<!--This button will delete the project in the same row without a warning-->
					<td class="table-text">
						<div class="col-sm-1">
								{!! Form::open(['route' => ['project.destroy', $project->id], 'method'=>'DELETE']) !!}
								{!! Form::submit('Verwijderen', array('class'=>'btn btn-danger')) !!}
								{!! Form::close() !!}
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
