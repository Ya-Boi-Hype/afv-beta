<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Vatsim\Xml\Facades\Xml as VatsimXML;
use App\Models\User;

class UpdateRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the user\'s data in the DB';

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
        $users = User::chunk(20, function ($users) {
            foreach ($users as $user) {
                $data = VatsimXML::getData($user->id, 'idstatusint');
                $user->name_first = $data->name_first;
                $user->name_last = $data->name_last;
                $user->rating_atc = self::humanize_atc_rating($data->rating);
                $user->save();
            }
        });
    }

    protected static function humanize_atc_rating($rating)
    {
        switch ($rating) {
            case -1:
                return 'INA';
            case 0:
                return 'SUS';
            case 1:
                return 'OBS';
            case 2:
                return 'S1';
            case 3:
                return 'S2';
            case 4:
                return 'S3';
            case 5:
                return 'C1';
            case 7:
                return 'C3';
            case 8:
                return 'I1';
            case 10:
                return 'I3';
            case 11:
                return 'SUP';
            case 12:
                return 'ADM';
        }
    }
}
