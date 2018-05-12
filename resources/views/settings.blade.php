@extends('layouts.app')

@section('content')

    <div class="row">

        @if(Session::get('success'))
            <div class="col-md-12">
                <br />
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="col-md-12">
                <br />
                <div class="alert alert-danger">
                    Oops!
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="col-md-6">
            <div class="card mb-3 {{ Auth::user()->dark_theme_status ? 'text-white bg-dark' : null }}">
                <h5 class="card-header">Notifications</h5>
                <div class="card-body">
                    <p class="card-text">
                        You can set a webhook url if you want to get notified when a new screenshot is uploaded.
                    </p>
                    <form method="POST" action="{{ route('settings.slackwebhook.update') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Slack Webhook</label>
                            <input class="form-control" placeholder="https://hooks.slack.com/services/T00000000/B00000000/XXXXXXXXXXXXXXXXXXXXXXXX" name="slack_webhook_url" type="text" value="{{ Auth::user()->slack_webhook_url }}">
                        </div>
                        <div class="form-group">
                            <label>Discord Webhook</label>
                            <input class="form-control" placeholder="https://discordapp.com/api/webhooks/000000000000000000/XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" name="discord_webhook_url" type="text" value="{{ Auth::user()->discord_webhook_url }}">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Save changes">
                    </form>
                </div>
            </div>

            <div class="card mt-3 {{ Auth::user()->dark_theme_status ? 'text-white bg-dark' : null }}">
                <h5 class="card-header">
                    User Interface
                </h5>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.account.darktheme.update') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">

                        <h5 class="card-title">Dark Theme</h5>
                        <p class="card-text">
                            <select name="dark_theme" class="form-control">
                                <option value="0">Disabled</option>
                                <option value="1" @if(Auth::user()->dark_theme_status) selected @endif>Enabled</option>
                            </select>
                        </p>

                        <input type="submit" class="btn btn-primary" value="Save changes">
                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card {{ Auth::user()->dark_theme_status ? 'text-white bg-dark' : null }}">
                <h5 class="card-header">
                    API Settings
                </h5>
                <div class="card-body">
                    <h5 class="card-title">Key</h5>
                    <p class="card-text">
                        Keep this key secret, with this key you are able to upload screenshots.
                        @if(Auth::user()->api_token)
                            <input style="margin-top: 10px;" class="form-control" disabled type="text" value="{{ Auth::user()->api_token }}"/>
                        @else
                        <div class="alert alert-danger" role="alert">
                            <b>Woops, looks like you don't have a API key yet. Please generate one by using the button below.</b>
                        </div>
                        @endif
                        </p>
                        <form method="POST" action="{{ route('settings.key.generate') }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="Generate new API key" />

                            @if(Auth::user()->api_token != null)
                                <a href="#" class="card-text pull-right" style="margin-top: 6px;" data-toggle="modal" data-target="#ShareX-Config">
                                    <small class="text-muted">Pre-filled ShareX Config</small>
                                </a>
                            @endif
                        </form>
                </div>
            </div>
            @if(Auth::user()->isAdmin())
                <div class="card mt-3 {{ Auth::user()->dark_theme_status ? 'text-white bg-dark' : null }}">
                    <h5 class="card-header">
                        Admin Settings
                    </h5>
                    <div class="card-body">
                        <p class="card-text">
                            If you're wanting to edit, delete or create users please click the button below.<br />
                            <a href="{{ route('settings.users') }}" class="btn btn-primary mt-2">Manage Users</a>
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-3 {{ Auth::user()->dark_theme_status ? 'text-white bg-dark' : null }}">
        <h5 class="card-header">
            Account
        </h5>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.account.update') }}">
                <input type="hidden" name="_method" value="PUT" />
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" />
                </div>
                <input type="submit" class="btn btn-primary" value="Save changes"/>
            </form>
            <hr />
            <form method="POST" action="{{ route('settings.account.password.update') }}">
                <input type="hidden" name="_method" value="PUT" />
                {{ csrf_field() }}
                <div class="form-group">
                    <label>New password</label>
                    <input type="password" class="form-control" name="password" placeholder="•••••••••" />
                </div>
                <div class="form-group">
                    <label>Confirm new password</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="•••••••••" />
                </div>
                <input type="submit" class="btn btn-primary" value="Save changes"/>
            </form>
        </div>
    </div>

    @if(Auth::user()->api_token != null)
    <div class="modal fade" id="ShareX-Config" tabindex="-1" role="dialog" aria-labelledby="ShareX Config" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ShareX Config</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" rows="12" disabled>
{
  "Name": "Screenshot CMS",
  "DestinationType": "ImageUploader",
  "RequestURL": "{{ env('APP_URL') }}/screenshots/upload",
  "FileFormName": "file",
  "Arguments": {
    "key": "{{ Auth::user()->api_token }}",
    "file": "%guid"
  },
  "URL": "$json:screenshot.url$"
}
                    </textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>


    @endif
@endsection