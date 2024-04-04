<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;
use App\Models\HardwareKey;
use App\Notifications\HardwareKeyNoti;
use Carbon\Carbon;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $keys = HardwareKey::whereDate('exDate', '<=', Carbon::now()->addDays(2))->get();

            foreach ($keys as $key) {
                $users = User::all(); 

                foreach ($users as $user) {
                    $user->notify(new HardwareKeyNoti($key->device->name));
                }
            }
        })->daily();
        }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
