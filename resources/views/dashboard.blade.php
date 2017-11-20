@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Screenshots <span class="badge badge-dark float-right">{{ $screenshots_count }}</span></h4>
                <p class="card-text">
                    A list of screenshots that are taken will show here.
                </p>
                @if($last_added_empty == false)
                    <p class="card-text"><small class="text-muted">Last screenshot added {{ $last_added->DiffForHumans() }}</small></p>
                @endif
                <a href="{{ route('screenshots.recent') }}" class="btn btn-primary">View Screenshots</a>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Settings</h4>
                <p class="card-text">
                    Configured settings will show here, you can reconfigure them by pressing the blue button below.
                </p>
                <a href="{{ route('settings') }}" class="btn btn-primary">View Settings</a>
            </div>
            <div class="card-footer">
                <small class="text-muted">Last updated {{ $updated_at->DiffForHumans() }}</small>
            </div>
        </div>
    </div>

    <hr />

</div>
@endsection
