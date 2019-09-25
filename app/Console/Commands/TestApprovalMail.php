<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Notifications\HfTestApprovalNotification;

class TestApprovalMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:approval {cid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $cid = $this->argument('cid');
        try {
            $user = User::findOrFail($cid);
        } catch (ModelNotFoundException $e) {
            echo 'User could not be found';

            return;
        }

        $user->notify(new HfTestApprovalNotification());
        echo 'Email queued!';
    }
}
