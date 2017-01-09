@extends('layouts.app')

@section('title')
	Gebruikers

@endsection

@section('content')

<!--Button to add a new users, directs the user to the create page-->
<div style="float:left">
	<a class="btn btn-primary" href="{!! url('user/create') !!}">
		Project toevoegen
	</a>
</div>

<!--Table headers-->
	@if (count($users) > 0)
		<table class="table table-striped table-hover">
			<thead>
				<th class="col-sm-1">Id</th>
				<th class="col-sm-4">Naam</th>
			</thead>

<!--Table will be filled with the users present in the database-->
			<tbody>
				@foreach ($users as $user)
				<tr class="row-link" style="cursor: pointer;"
									data-href="{{action('UserController@show', ['id' => $user->id]) }}">
					<td class="table-text">{{ $user->id }}</td>
					<td class="table-text">{{ $user->name}}</td>

<!--This button will redirect the user to the /user/edit page-->
					<td class="table-text">
						<div>
							<a class="btn btn-primary" href="{!! url('user/' . $user->id .'/edit' ) !!}">
								Wijzigen
							</a>
						</div>
					</td>

<!--This button will delete the user in the same row without a warning-->
					<td class="table-text">
						<div class="col-sm-1">
								{!! Form::open(['route' => ['user.destroy', $user->id], 'method'=>'DELETE']) !!}
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
	        window.document.user = $(this).data("href");
	    });
	    $('#cohort-tabs a:first').tab('show') // Select first tab
	});
</script>
@endsection
