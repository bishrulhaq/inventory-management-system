@extends('layouts.admin_master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Activity Log</h3>
        </div>
        <div class="card-body">
            <livewire:activity-log/>
        </div>
    </div>
@endsection
