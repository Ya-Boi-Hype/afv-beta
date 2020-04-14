<?php

namespace App\Console\Commands;

use App\Http\Controllers\AfvApiController;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

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
        $vatsim_api = new Client([
            'base_uri' => 'https://api.vatsim.net/api/',
            'timeout' => 5,
        ]);

        try {
            $facility_engineers = json_decode(AfvApiController::doGET('permissions/Facility Engineer/users', null, false));
            $facility_engineers = collect($facility_engineers);
            $facility_engineers = $facility_engineers->pluck('username');
        } catch (\Exception $e) {
            return $this->error('Couldn\'t fetch Facility Engineers: '.$e->getMessage);
        }

        $users = User::chunk(20, function ($users) use (&$vatsim_api, &$facility_engineers) {
            foreach ($users as $user) {
                $id = $user->id;
                try {
                    $response = $vatsim_api->request('GET', "ratings/$id");
                    $data = json_decode($response->getBody());
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                    continue;
                }

                $user->name_first = $data->name_first;
                $user->name_last = $data->name_last;
                $user->rating_atc = self::humanize_atc_rating($data->rating);
                $user->facility_engineer = (bool) $facility_engineers->contains($user->id);

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
