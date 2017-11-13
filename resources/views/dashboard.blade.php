@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Screenshots <span class="badge badge-dark float-right">241</span></h4>
                <p class="card-text">
                    A list of screenshots that are taken will show here.
                </p>
                <p class="card-text"><small class="text-muted">Last screenshot added 40 minutes ago</small></p>
                <a href="" class="btn btn-primary">View Screenshots</a>
            </div>
            <img class="card-img-bottom" src="https://upload.wikimedia.org/wikipedia/commons/3/36/Hopetoun_falls.jpg">
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Settings</h4>
                <p class="card-text">
                    Configured settings will show here, you can reconfigure them by pressing the blue button below.
                </p>
                <a href="" class="btn btn-primary">View Settings</a>
            </div>
            <div class="card-footer">
                <small class="text-muted">Last updated 3 minutes ago</small>
            </div>
        </div>
    </div>

</div>
@endsection
