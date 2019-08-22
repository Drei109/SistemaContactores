<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviarEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:Emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia emails a los destinatarios';

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
        $today = date('H:i:s');

        $data = array('name'=>"Test Name", 'date'=> $today);
        Mail::send('Mail.mail', $data, function($message) {
            $message->to('drei.rar@gmail.com', 'Name Test')->subject
                ('Test Subject');
            $message->from('AdmiWebOnline@gmail.com','From Test');
        });
        echo "HTML Email Sent. Check your inbox.";
    }
}
