@extends('layouts.app')

@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="offset-lg-3 offset-md-1" offset-xs-0>
            {{ $screenshots->links('partials.pagination') }}
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
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
                    @foreach ($screenshots->chunk(3) as $screenshot_1)
                        <div class="row">
                            @foreach($screenshot_1 as $screenshot)
                                <div class="col-md-4">
                                    <a target="_blank" href="{{ route('screenshot.get', $screenshot->name) }}">
                                        <img src="{{ url('/storage/screenshots/'.$screenshot->full_name) }}"
                                             alt="{{ $screenshot->name }}" class="img-thumbnail">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <br/>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection