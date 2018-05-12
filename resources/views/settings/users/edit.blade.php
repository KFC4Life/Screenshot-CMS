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

    <div class="card {{ Auth::user()->dark_theme_status ? 'text-white bg-dark' : null }}">
        <h5 class="card-header">
            Edit User
        </h5>
        <div class="card-body">
            <div class="card-text">

            </div>
            <form method="POST" action="{{ route('settings.users.update', $user->id) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT" />
                <div class="form-group">
                    <label>User ID</label>
                    <input type="text" value="{{ $user->id }}" class="form-control" disabled />
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" value="{{ $user->email }}" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option value="user">User</option>
                        <option value="admin" {{ $user->isAdmin() ? 'selected' : null }}>Admin</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Save Changes"/>
                <a href="{{ route('settings.users') }}" class="btn btn-danger ml-1">Cancel Editing</a>
            </form>
        </div>
    </div>

@endsection