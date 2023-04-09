<?php

namespace App\Listeners;

use App\Events\OnCreateRecord;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogCreateRecordListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OnCreateRecord  $event
     * @return void
     */
    public function handle(OnCreateRecord $event)
    {
        $model = $event->model;
        Log::query()->create([
            'initiator_id' => Auth::user()->id ?? null,
            'target' => $model->getTable(),
            'action' => 'create',
            'payload' => serialize($model->getAttributes())
        ]);
    }
}
