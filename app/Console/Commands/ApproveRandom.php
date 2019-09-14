<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Approval;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApproveRandom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'approve:random {qty} {actAs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approve a random number of users';

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
        echo 'Random approvals in progress...' . PHP_EOL;
        try {
            $user = User::findOrFail($this->argument('actAs'));
        } catch (ModelNotFoundException $e) {
            echo 'User not found';

            return;
        }

        if (! in_array('User Enable Write', $user->permissions)) {
            echo "User can't manage approvals";

            return;
        }

        $approved = 0;
        $newApprovals = Approval::pending()->inRandomOrder()->take($this->argument('qty'));

        foreach ($newApprovals->cursor() as $approval) {
            try {
                $approval->approve($this->argument('actAs'));
            } catch (\Exception $e) {
                continue;
            }
            $approved++;
        }
        Log::info($user->full_name.' ('.$user->id.') has approved '.$this->argument('qty')." random users ($approved successful)");

        echo $this->argument('qty')." random users approved ($approved successful)";
    }
}
