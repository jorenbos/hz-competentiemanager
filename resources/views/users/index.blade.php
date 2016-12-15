@extends('layouts.app')

@section('title')
	Gebruikers

@endsection

@section('content')

<!--Button to add new users, directs the user to the create page-->
<div style="float:left">
	<a class="btn btn-primary" href="{!! url('users/create') !!}">
		Gebruiker toevoegen
	</a>
</div>

<!--Table headers-->
	@if (count($users) > 0)
		<table class="table table-striped table-hover">
			<thead>
				<th class="col-sm-1">Id</th>
				<th class="col-sm-4">Naam</th>
			</thead>

<!--Table will be filled with the users in the database-->
			<tbody>
				@foreach ($users as $user)
				<tr class="row-link" style="cursor: pointer;"
									data-href="{{action('UserController@show', ['id' => $user->id]) }}">
					<td class="table-text">{{ $user->id }}</td>
					<td class="table-text">
						<a href="{{url("/users/$user->id")}}">{{ $user->name }}</a>
					</td>

<!--This button will redirect the user to the /users/edit page-->
					<td class="table-text">
						<div>
							<a class="btn btn-primary" href="{!! url('users/' . $user->id .'/edit' ) !!}">
								Wijzigen
							</a>
						</div>
					</td>

<!--This button will delete the user, without a warning -->
					<td class="table-text">
						<div class="col-sm-1">
							<form action="{{url("/users/$user->id")}}" method="post">
									<input type="hidden" name="_method" value="DELETE">
									{{csrf_field()}}
									<span class="input-group-btn">
											<input type="submit" class="btn btn-sm btn-danger" value="Verwijder">
									</span>
							</form>
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
