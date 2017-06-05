@extends('layouts.master')
@section('title', 'Competentie behoefte')
@section('content')
{{-- BreadCrumbs --}}
<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li class="active">Demand</li>
</ol>

{{-- Page Title --}}
<h1>Demand</h1>



    <table class="table">
        <thead>
            <th>Competentie</th>
            <th>Gewogen gemiddelde vraag</th>
        </thead>

        <tbody>
            @foreach ($competencies as $name => $demand)
                <tr>
                    <td>{{ $name }}</td>
                    <td>{{ $demand }}</td>

                </tr>

            @endforeach
        </tbody>


    </table>


@endsection
