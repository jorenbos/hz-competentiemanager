@extends('layouts.master')
@section('title', 'Kies competenties')
@section('content')
    {{-- BreadCrumbs --}}
    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Te Kiezen Competenties</li>
    </ol>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    {!! Form::open(['url' => 'placeholder', 'method'=> 'GET']) !!}
    <div class="form-group col-md-3 col-sm-12">
        <label for="student">Student</label>
        <select class="form-control" id="student", onchange="changeFunc();">
            <option selected>Geen</option>
            @foreach($students as $student)
                <option value="{{$student->id}}">{{$student->name}}</option>
                {{ $studentId = $student->id }}
            @endforeach
        </select>
    </div>
    {!! Form::close() !!}
    <script>
        function changeFunc() {
            var e = document.getElementById('student');
            var selected = e.options[e.selectedIndex].value;
            window.location.href = 'http://hz.app/student/'+ selected + '/competencies';
        }
    </script>





    <table class="table">
        <thead>
            <th>Naam</th>
            <th>Afkorting</th>
        </thead>

        @foreach($comps as $comp)
            <tr>
                <td>
                    <a href="{{url("/competencies/$comp->id")}}">{{$comp->name}}</a>
                </td>
                <td>
                    {{$comp->abbreviation}}
                </td>
			    <td>

                </td>
            </tr>
        @endforeach
    </table>
@endsection
