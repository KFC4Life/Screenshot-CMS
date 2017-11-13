@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-md-11 col-sm-12 col-xs-12">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link @if(Request::route()->getName() == 'screenshots.recent') active @endif" href="{{ route('screenshots.recent') }}">Recent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Request::route()->getName() == 'screenshots.overview') active @endif" href="{{ route('screenshots.overview') }}">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Upload</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">

                    <div class="col-md-8">
                        <div class="card text-center">
                            <div class="card-header">
                                <b>235fASFsdgsgf239t</b>
                            </div>

                            <img class="card-img-top" src="https://iso.500px.com/wp-content/uploads/2016/03/stock-photo-142984111-1500x1000.jpg" class="img-fluid" alt="Image not found!">

                            <div class="card-footer text-muted">
                                2 days ago
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
@endsection
