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

        <tbody id="demandTableBody">
            <tr>
                <td colspan= "2" align="center"><img src="{{ asset('img/loading.svg') }}"></br>
                Competentiebehoefte wordt berekend.</td>
            </tr>
        </tbody>


    </table>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/demandIndex.js') }}"></script>

@endsection
