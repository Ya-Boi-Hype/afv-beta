<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserBan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:ban {cid} {actAs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bans a user indefinitely from accessing the beta';

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
            if ($user->approval()->exists()) {
                $approval = $user->approval;
            } else {
                echo 'Approval could not be found';

                return;
            }
        } catch (ModelNotFoundException $e) {
            try {
                $approval = Approval::where('user_id', $cid)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                echo 'Approval could not be found';

                return;
            }
        }

        try {
            $approval->revoke($this->argument('actAs'));
        } catch (\Exception $e) {
            echo 'Error: AFV Server replied with code '.$e->getCode();

            return;
        }

        $approval->banned_on = now();
        $approval->save();
        echo "$cid has been banned";
    }
}
