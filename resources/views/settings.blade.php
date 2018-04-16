@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-md-11">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Upload key</h4>
                    <p class="card-text">
                        Keep this key secret, with this key you are able to upload screenshots.
                        @if($upload_key)
                            <input style="margin-top: 10px;" class="form-control" disabled type="text" value="{{ $upload_key }}"/>
                        @else
                            <div class="alert alert-danger" role="alert">
                                <b>Woops, looks like you don't have a upload key yet. Please generate one by using the button below.</b>
                            </div>
                        @endif
                    </p>

                    <form method="POST" action="{{ route('settings.key.generate') }}">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="Generate new key" /><a href="#" class="card-text pull-right" style="margin-top: 6px;"><small class="text-muted">Access Log</small></a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-11">
            <br>
            <div class="card">
                <h5 class="card-header">Personal</h5>
                <div class="card-body">
                    <h5 class="card-title">Slack Webhook</h5>
                    <p class="card-text">Set a slack webhook url to get notified when a new screenshot is uploaded.</p>
                    <form method="POST" action="{{ route('settings.slackwebhook.update') }}">
                        <input style="margin-top: 10px; margin-bottom: 10px;" class="form-control" placeholder="Now it is empty!" name="slack_webhook_url" type="text" value="{{ Auth::user()->slack_webhook_url }}">
                        <h5 class="card-title">Discord Webhook</h5>
                        <p class="card-text">Set a discord webhook url to get notified when a new screenshot is uploaded.</p>
                        <input style="margin-top: 10px; margin-bottom: 10px;" class="form-control" placeholder="Now it is empty!" name="discord_webhook_url" type="text" value="{{ Auth::user()->discord_webhook_url }}">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="Save">
                    </form><br>
                </div>
            </div>
        </div>

        @if(Session::get('msg'))
        <div class="col-md-11">
            <br />
            <div class="alert alert-primary" role="alert">
                {{ Session::get('msg') }}
            </div>
        </div>
        @endif

    </div>
@endsection
