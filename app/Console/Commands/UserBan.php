<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Http\Controllers\AfvApiController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserBan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:ban {cid}';

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
            $user = User::firstOrFail('id', $cid);
        } catch (ModelNotFoundException $e) {
            return "User $cid not found";
        }

        $data = ['Username' => (string) $cid, 'Enabled' => false];
        try {
            AfvApiController::doPUT('users/enabled', [$data]);
        } catch (\Exception $e) {
            return 'Error: AFV Server replied with '.$e->getCode();
        }

        if ($user->approval()->exists()) {
            $user->approval->setAsPending();
            $user->approval->banned_at = now();

            return "$cid has been banned";
        } else {
            return "$cid removed from accessing AFV, but didn't have access to website";
        }
    }
}
