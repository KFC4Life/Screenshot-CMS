@extends('layouts.app')

@section('content')

    @if($years == '[]')
        <h1 class="text-center">Can't show statistics, no screenshots found.</h1>
    @else
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @foreach($years as $year)
                        {!! $charts[$year->year]->render() !!}
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endsection