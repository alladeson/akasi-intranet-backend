<?php

namespace App\Console\Commands;

use App\Mail\WeeklyNotificationMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WeeklyNotif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification all saturdays to users for their report';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $users = User::all();
        foreach ($users as $user) {
            //Mail::to($user->email)->send(new WeeklyNotificationMail($user));
            Mail::to("mechak.biti@akasigroup.com")->send(new WeeklyNotificationMail($user));
        }
        return Command::SUCCESS;
    }
}