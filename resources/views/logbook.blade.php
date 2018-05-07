@extends('layouts.app')

@section('content')
    <div class="container">

        @if(count($log) > 0)
        <div class="text-center">
            <h1>Logbook</h1>
            <div class="btn-group">
                <form action="{{ route('logbook.clear') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="Clear logbook">
                </form>
            </div>
            <hr />
        </div>

        <table class="table table-dark table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Event</th>
                    <th scope="col">Info</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($log as $line)
                <tr @if($line->event == 'upload') class="bg-success" @elseif($line->event == 'delete') class="bg-warning" @elseif($line->event == 'restore') class="bg-primary" @elseif($line->event == 'permanently-delete') class="bg-danger" @else class="bg-secondary" @endif>
                    <th>{{ $line->event }}</th>
                    <td>{{ $line->info }}</td>
                    <td>{{ $line->ip }}</td>
                    <td>{{ $line->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $log->links() }}
        @else
            <h1 class="text-center">
                There are no logged actions found.<br />Come back later.
            </h1>
        @endif
    </div>
@endsection
@section('css')
    <style>
        .pagination {
            justify-content: center;
        }
    </style>
@endsection
