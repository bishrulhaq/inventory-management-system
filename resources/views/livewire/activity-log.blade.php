<div>
    <div class="terminal-container">
        <div class="terminal-body">
            <ul>
                @foreach($logs as $log)
                    <li>{{ $log->description }} , {{ $log->causer_type }} , {{ $log->updated_at }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
