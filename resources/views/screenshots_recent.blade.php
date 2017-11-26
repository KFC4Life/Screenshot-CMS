@extends('layouts.app')

@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="offset-md-3 col-md-8 col-lg-9">
            {{ $screenshots->links('partials.pagination') }}
        </div>


        <div class="offset-lg-2 col-lg-9 col-sm-12 col-xs-12 col-md-12">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link @if(Request::route()->getName() == 'screenshots.recent') active @endif"
                               href="{{ route('screenshots.recent') }}">Recent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Request::route()->getName() == 'screenshots.overview') active @endif"
                               href="{{ route('screenshots.overview') }}">Overview</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">


                    @foreach($screenshots as $screenshot)
                        <div class="card">
                            <img class="card-img-top" src="{{ url('/storage/screenshots/'.$screenshot->full_name) }}"
                                 alt="{{ $screenshot->name }}">
                            <div class="card-footer">
                                <small class="text-muted">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $screenshot->created_at)->DiffForHumans() }}</small>
                            </div>
                        </div>

                        <br/>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
@endsection
