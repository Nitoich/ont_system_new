<?php

namespace App\Providers;

use App\Events\OnCreateRecord;
use App\Events\OnDeleteRecord;
use App\Events\OnUpdateRecord;
use App\Events\Register;
use App\Listeners\LogCreateRecordListener;
use App\Listeners\LogDeleteRecordListener;
use App\Listeners\LogUpdateRecordListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Register::class => [],
        OnCreateRecord::class => [
            LogCreateRecordListener::class
        ],
        OnUpdateRecord::class => [
            LogUpdateRecordListener::class
        ],
        OnDeleteRecord::class => [
            LogDeleteRecordListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
