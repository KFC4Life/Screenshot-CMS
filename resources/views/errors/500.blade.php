Error 500
@if($exception->getMessage())
    {{ $exception->getMessage() }}
@endif