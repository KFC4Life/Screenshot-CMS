@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-md-11">
            <div class="card">
                <div class="card-body">
                    @foreach($years as $year)
                        {!! $charts[$year->year]->render() !!}
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@endsection