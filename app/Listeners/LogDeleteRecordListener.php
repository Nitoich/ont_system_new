<?php

namespace App\Listeners;

use App\Events\OnDeleteRecord;

class LogDeleteRecordListener
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
     * @param  \App\Events\OnDeleteRecord  $event
     * @return void
     */
    public function handle(OnDeleteRecord $event)
    {
        //
    }
}
