@extends('layouts.app')

@section('title')
	Lijst van competenties
@endsection

@section('content')
<div style="float:left">
	<a class="btn btn-primary" href="{!! url('competency/create') !!}">
		Competentie toevoegen
	</a>
</div>

<div style="float:left">
	<a class="btn btn-primary" href="{!! url('competency/edit') !!}">
		Een competentie wijzigen
	</a>
</div>

<div style="float:left">
	<a class="btn btn-primary" href="{!! url('competency/show') !!}">
		Alle competenties weergeven
	</a>
</div>

	@if (count($competenties) > 0)
	<!-- Shows ID of item in database and name-->
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
					<td class="table-text">
						<div>
							<a class="btn btn-primary" href="{!! url('competency/' . $competency->id .'/edit' ) !!}">
								Competentie wijzigen
							</a>
						</div>
					</td>

					<td class="table-text">
						<div class="col-sm-1">
							{!! Form::open(['route' => ['competency.destroy', $competency->id], 'method'=>'DELETE']) !!}
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
