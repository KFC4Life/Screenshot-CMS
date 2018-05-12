@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="text-center">
            <h1>Screenshots</h1>
            <p>Here you can take a look at your taken screenshots.<br />
                @if(Auth::user()->hasRole('admin')) Which screenshots do you want to see? @endif
            </p>
            @if(Auth::user()->hasRole('admin'))
            <div class="btn-group">
                <a href="{{ route('screenshots.mine') }}" class="btn btn-secondary @if(Route::currentRouteName() == 'screenshots.mine') active @endif">Only mine</a>
                <a href="{{ route('screenshots.all') }}" class="btn btn-secondary @if(Route::currentRouteName() == 'screenshots.all') active @endif">All</a>
                <a href="{{ route('screenshots.trash') }}" class="btn btn-secondary @if(Route::currentRouteName() == 'screenshots.trash') active @endif">Trash</a>
            </div>
            @endif
            <hr />
        </div>

        {{ $screenshots->links() }}

        @if(count($screenshots) > 0)
            <table class="table table-responsive table-striped {{ Auth::user()->dark_theme_status ? 'table-dark' : null }}">
                <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Created at</th>
                    @if(Route::currentRouteName() == 'screenshots.all' | Route::currentRouteName() == 'screenshots.trash')
                        <th scope="col">User</th>
                    @endif
                    @if(Route::currentRouteName() == 'screenshots.trash')
                        <th scope="col">Deleted at</th>
                    @endif
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($screenshots as $screenshot)
                        <tr>
                            <td><img class="img-responsive" src="{{ url('/storage/screenshots/'.$screenshot->full_name) }}" /></td>
                            <td>{{ $screenshot->name }}</td>
                            <td>{{ $screenshot->created_at.' ('. \Carbon\Carbon::createFromTimeString($screenshot->created_at)->diffForHumans() .')' }}</td>
                            @if(Route::currentRouteName() == 'screenshots.all' | Route::currentRouteName() == 'screenshots.trash')
                                <td>{{ $screenshot->user->name.' (#'. $screenshot->user->id .')' }}</td>
                            @endif
                            @if(Route::currentRouteName() == 'screenshots.trash')
                                <td>{{ $screenshot->deleted_at.' ('. \Carbon\Carbon::createFromTimeString($screenshot->deleted_at)->diffForHumans() .')' }}</td>
                            @endif
                            <td>
                                @if(Route::currentRouteName() == 'screenshots.all' | Route::currentRouteName() == 'screenshots.mine')
                                    <form method="POST" action="{{ route('screenshots.destroy', $screenshot->name) }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{ csrf_field() }}
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('screenshot.get', $screenshot->name) }}" target="_blank" class="btn btn-outline-primary">View</a>
                                            <input type="submit" class="btn btn-outline-danger" value="Delete">
                                        </div>
                                    </form>
                                @else
                                    <div class="btn-group">
                                        <form method="POST" action="{{ route('screenshots.restore', $screenshot->name) }}">
                                            <input type="hidden" name="_method" value="PUT">
                                            {{ csrf_field() }}
                                            <input type="submit" class="btn btn-outline-primary" value="Restore">
                                        </form>
                                        <form method="POST" action="{{ route('screenshots.destroy.permanently', $screenshot->name) }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{ csrf_field() }}
                                            <input type="submit" class="btn btn-outline-danger" value="Delete Permanently">
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3 class="text-center">No screenshots found in this category.</h3>
        @endif

        {{ $screenshots->links() }}
    </div>
@endsection
@section('css')
    <style>
        .img-responsive{width:60%;}

        .pagination {
            justify-content: center;
        }

        /* Something secret for dark theme in the future */
        /*body {*/
            /*background: dimgray !important;*/
        /*}*/
    </style>
@endsection