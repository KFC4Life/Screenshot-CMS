@extends('layouts.app')

@section('content')

    @if($years == '[]')
        <h1 class="text-center">Can't show statistics, no screenshots found.</h1>
    @else
    <div class="row text-center">
        <div class="col-md-6">
            <label>Screenshots</label>
            <h3>{{ count(\App\Models\Screenshot::all()) }}</h3>
        </div>
        <div class="col-md-6">
            <label>Size</label>
            <h3>{{ $file_size }}MB</h3>
        </div>
        <hr />
    </div>

    <hr />

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