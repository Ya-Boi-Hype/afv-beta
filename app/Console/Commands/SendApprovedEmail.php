<?php

namespace App\Console\Commands;

use App\Models\Approval;
use Illuminate\Console\Command;
use App\Notifications\UpdateEmail;

class SendApprovedEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'approved:sendmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an update email to all approved users';

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
        $approvals = Approval::approved();
        foreach ($approvals->cursor() as $approval) {
            if ($approval->user) {
                $approval->user->notify(new UpdateEmail());
            }
        }
    }
}
