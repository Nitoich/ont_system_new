<?php

namespace App\Console;

use App\Models\Semester;
use App\Services\SemesterService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    private SemesterService $semesterService;
    public function __construct(Application $app, Dispatcher $events, SemesterService $semesterService)
    {
        $this->semesterService = $semesterService;
        parent::__construct($app, $events);
    }

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $today = new \DateTime('now');
            $semester = Semester::query()
                ->whereDate('date_start', '>=', $today)
                ->whereDate('date_end', '<', $today)
                ->where('active', false)
                ->update([
                    'active' => true
                ]);

            if($semester) {
                $current_semester = $this->semesterService->getCurrentSemester();
                if(!$current_semester) {
                    return false;
                }
                $current_semester->active = false;
                $current_semester->save();
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
