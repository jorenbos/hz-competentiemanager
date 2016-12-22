@extends('layouts.app')

@section('title',$user->name)

@section('content')

<!--Buttons to edit or delete this specific user-->
<td>
  <div class="input-group" role="group" aria-label="...">
    <span class="input-group-btn">
      <a class="btn btn-sm btn-default" href="{{url("/users/$user->id/edit")}}">Bewerk</a>
    </span>
      <form action="{{url("/users/$user->id")}}" method="post">
        <input type="hidden" name="_method" value="DELETE">
          {{csrf_field()}}
            <span class="input-group-btn">
              <input type="submit" class="btn btn-sm btn-danger" value="Verwijder">
            </span>
      </form>
  </div>
</td>

<!--Specific user is shown in a table for readablitiy purposes-->
<table class="table table-striped table-hover">

  <thead>
    <th class="col-sm-1">Id</th>
    <th class="col-sm-4">Email</th>
    <th class="col-sm-4">Naam</th>
    <th class="col-sm-4">Project</th>
  </thead>
  
<!--Data about the user-->
    <div class="col-sm-4 col-sm-offset-4">
      <tr class="row-link" style="cursor: pointer;">
        <td class="table-text">{{ $user->id }}</td>
        <td class="table-text">{{ $user->email }}</td>
        <td class="table-text">{{ $user->name }}</td>
      </tr>
    </div>
  </table>
@endsection
