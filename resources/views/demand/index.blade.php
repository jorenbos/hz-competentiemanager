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
            <th>Maximum potentiele vraag</th>
            <th>Gewogen gemiddelde vraag</th>
        </thead>

        <tbody>
            @foreach ($competencies as $competency)
                <tr>
                    <td>{{$competency['competency']->name}}</td>
                    <td>{{$competency['count']}}</td>
                    <td>{{$competency['mean_demand']}}</td>

                </tr>

            @endforeach
        </tbody>


    </table>


@endsection
