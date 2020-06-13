<?php

namespace App\Console\Commands;

use App\Mail\NotifyEmail;
use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Mail;

class Notify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notify everyday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emails = User::pulck('email')->toArray();
        $data = ['title' => 'programming', 'body' => 'PHP'];

        foreach ($emails as $email) {
            Mail::to('hossamhamed@gmail.com')
            ->bcc("hossamhamed94.hh@gmail.com")
            ->send(new NotifyEmail($data));
        }
    }
}
