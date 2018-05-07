@extends('layouts.app')

@section('content')

        @if($errors->any())
            <div class="alert alert-danger">
                <p>Oops!</p>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::get('danger'))
            <div class="alert alert-danger">
                {{ Session::get('danger') }}
            </div>
        @endif

        <div class="card">
            <h5 class="card-header">
                User Settings
            </h5>
            <div class="card-body">
                <p class="card-text">
                    Here you can edit, delete or create users. If you want to go back to the personal settings page click the button below.<br />
                    <a href="{{ route('settings') }}" class="btn btn-primary mt-2">Return back</a>
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <h5 class="card-header" style="border-bottom: 0;">
               Users
            </h5>
            <div class="card-body table-responsive" style="padding: 0;">
                <table class="table table-striped" style="margin-bottom: 0;">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{!! $user->isAdmin() ? '<span class="badge badge-primary" style="font-size: 1.0em;">Admin</span>' : ''  !!}</td>
                                <td>
                                        @if($user->id == Auth::id())
                                            <span class="badge badge-secondary" style="font-size: 1.0em;">You're this</span>
                                        @else
                                            <div class="btn-group">
                                                <a href="{{ route('settings.users.edit', $user->id) }}" class="btn btn-outline-primary">Edit</a>
                                                <a href="" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete-user-{{ $user->id }}">Delete</a>
                                            </div>
                                        @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                Create a user
            </div>
            <div class="card-body">
                <form action="{{ route('settings.users') }}" method="POST">

                    {{ csrf_field() }}

                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" placeholder="John Doe" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" placeholder="johndoe@example.com" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" placeholder="A password" name="password">
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input class="form-control" type="password" placeholder="A password" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <input type="submit" value="Create" class="btn btn-primary">
                </form>
            </div>
        </div>

        @foreach($users as $user)
            @if($user->id !== Auth::id())
                <div class="modal" id="delete-user-{{ $user->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete User #{{ $user->id }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="delete-form-{{ $user->id }}" method="POST" action="{{ route('settings.users.delete', $user->id) }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE" />
                                <div class="modal-body">
                                    <p>What do you want to do with the screenshots from user #{{ $user->id }} ({{ $user->name }}) ?</p>
                                    <form method="POST" action="{{ route('settings.users.delete', $user->id) }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE" />

                                        <div class="form-group">
                                            <select onChange="deleteFormHelper(this);" id="{{ $user->id }}" name="files_destination" class="form-control">
                                                <label>What do you want to do with the screenshots from user #{{ $user->id }} ({{ $user->name }}) ?</label>
                                                <option value="deleted">Delete them</option>
                                                <option value="account">Keep them</option>
                                            </select>
                                        </div>
                                        <div class="form-group user-select" id="userMigrateDestination--{{ $user->id }}">
                                            <label>To which user do you want to migrate the screenshots to?</label>
                                            <select class="form-control" name="migration_user">
                                                @foreach(App\User::where('id', '!=', $user->id)->get() as $u)
                                                    <option value="{{ $u->id }}">{{ $u->name.' (#'. $u->id .') - '.$u->email }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="event.preventDefault();document.getElementById('delete-form-{{ $user->id }}').submit();">Delete User</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
@endsection

@section('scripts')

    <script>

        var userSelectDivs = document.getElementsByClassName('form-group user-select');

        Array.prototype.forEach.call(userSelectDivs, function (element) {
            element.style.display = "none";
        });

        function deleteFormHelper (selectObj) {

            console.log(selectObj.selectedIndex);

            if(selectObj.selectedIndex === 1) {
                var combined1 = 'userMigrateDestination--' + selectObj.id;
                Array.prototype.forEach.call(userSelectDivs, function (element1) {
                    if(element1.id = combined1) {
                        element1.style.display = "block";
                    }
                });
            }
            if(selectObj.selectedIndex === 0) {
                var combined = 'userMigrateDestination--' + selectObj.id;
                Array.prototype.forEach.call(userSelectDivs, function (element) {
                    if(element.id = combined) {
                        element.style.display = "none";
                    }
                });
            }

        }

    </script>

@endsection