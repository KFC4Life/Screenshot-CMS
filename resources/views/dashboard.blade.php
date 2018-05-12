@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="text-center">
                <h1>Welcome, {{ Auth::user()->name }}!</h1>
                <hr />
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card {{ Auth::user()->dark_theme_status ? 'text-white bg-dark' : null }}">
                <div class="card-body">
                    <h4 class="card-title">Screenshots <span class="badge badge-primary float-right">{{ count(\App\Models\Screenshot::where('user_id', '=', Auth::id())->get()) }}</span></h4>
                    <p class="card-text">
                        A list of screenshots that are taken will show here.
                    </p>
                    @if(count(\App\Models\Screenshot::where('user_id', '=', Auth::id())->get()) > 0)
                        <p class="card-text">
                            <small class="text-muted">Last screenshot added {{ \Carbon\Carbon::createFromTimeString(\App\Models\Screenshot::latest()->first()->created_at)->diffForHumans() }}</small>
                        </p>
                    @endif
                    <a href="{{ route('screenshots.mine') }}" class="btn btn-primary">View Screenshots</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card {{ Auth::user()->dark_theme_status ? 'text-white bg-dark' : null }}">
                <div class="card-body">
                    <h4 class="card-title">Settings</h4>
                    <p class="card-text">
                        Configured settings will show here, you can reconfigure them by pressing the blue button below.
                    </p>
                    <a href="{{ route('settings') }}" class="btn btn-primary">View Settings</a>
                </div>
            </div>
        </div>
    </div>

    @if(Session::get('danger'))
        <div class="alert alert-danger">
            {{ Session::get('danger') }}
        </div>
    @endif
@endsection
