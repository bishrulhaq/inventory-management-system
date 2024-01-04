<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    public $logs;

    public function mount()
    {
        $this->logs = Activity::all();
    }

    public function render()
    {
        return view('livewire.activity-log');
    }
}
