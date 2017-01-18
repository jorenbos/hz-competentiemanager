@extends('layouts.app')

@section('title')
    Lijst van competenties
@endsection

@section('content')

    <table class="table table-striped table-hover">
        <thead>
            <th class="col-sm-4">Competentie</th>
            <th class="col-sm-2">Maximum potentiele vraag</th>
            <th class="col-sm-2">Gewogen gemiddelde vraag</th>
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
