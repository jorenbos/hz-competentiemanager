@extends('layouts.master')
@section('title', 'Lijst van competenties')
@section('content')
    {{-- BreadCrumbs --}}
	<ol class="breadcrumb">
    	<li><a href="/">Home</a></li>
    	<li class="active">Competenties</li>
	</ol>

	{{-- Page Title --}}
	<h1>Competenties</h1>

	{{-- Create Button --}}
	<a href="competencies/create" class="btn btn-primary pull-right">Competentie Toevoegen</a>


	@if (count($competenties) > 0)
	<!-- Shows ID of item in database and name-->
		<table class="table">
			<thead>
				<th>Id</th>
				<th>Naam</th>

			</thead>
			<tbody>
				@foreach ($competenties as $competency)
				<tr data-href="{{action('CompetencyController@show', ['id' => $competency->id]) }}">
					<td>{{ $competency->id }}</td>
					<td>{{ $competency->name}}</td>
					<td>
						<div>
							<a class="btn btn-primary" href="{!! url('competencies/' . $competency->id .'/edit' ) !!}">
								Competentie wijzigen
							</a>
						</div>
					</td>

					<td class="table-text">
						<div class="col-sm-1">
							{!! Form::open(['route' => ['competencies.destroy', $competency->id], 'method'=>'DELETE']) !!}
							{!! Form::submit('Verwijderen', array('class'=>'btn btn-danger')) !!}
							{!! Form::close() !!}
						</div>
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
	        window.document.competency = $(this).data("href");
	    });
	    $('#cohort-tabs a:first').tab('show') // Select first tab
	});
</script>
@endsection
