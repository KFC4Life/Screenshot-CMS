@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-md-12">

            <table class="table table-striped">
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
                    <tr>
                        <th>{{ $line->event }}</th>
                        <td>{{ $line->info }}</td>
                        <td>{{ $line->ip }}</td>
                        <td>{{ $line->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $log->links('partials.pagination') }}


        </div>

    </div>
@endsection
