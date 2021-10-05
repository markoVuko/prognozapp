<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use stdClass;

class SenderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sender:cron {user_id}';

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
     * @return int
     */
    public function handle()
    {
        $user_id = $this->argument("user_id");
        $client = new \GuzzleHttp\Client();
        $url_r = "http://127.0.0.1:8000/api/reports";
        //$url_c = "http://127.0.0.1:8000/api/cities";
        $url_u = "http://127.0.0.1:8000/api/users";

        $res = $client->request('GET', $url_u."/".$user_id);
        $user = json_decode($res->getBody(), true);

        $res = $client->request('GET', $url_r, ['query' => $user['cities']]);
        $forecasts = json_decode($res->getBody(), true);

        $forecastsForUser = array();
        $i = 1;
        $niz = array();

            foreach ($forecasts as $f) {
                //TESTIRANJE
                //error_log(json_encode($f['city_name']));
                //odredjeni gradovi u weather api imaju specijalne karaktere
                //te ova petjla nece prepoznati gradove kao sto su Riga, koji ima posebno slovo i
                if(in_array($f['city_name'], $user['cities'])){

                    if($i % 5 == 1){
                        $niz = [];
                        $forecastsForUser[$f['city_name']] = [];

                    }
                    switch ($f['temp_min']) {
                        case ($f['temp_min'] < 10):
                            $prep = "a couple layers of warm clothes with long sleeves, a thick jacket, and a hat. ";
                            break;

                        case ($f['temp_min'] < 20):
                            $prep = "long sleeves with at least two layers of clothing, and perhaps a lighter jacket. ";
                            break;

                        case ($f['temp_min'] < 30):
                            $prep = "a short sleeved shirt, and some pants or potentially shorts. ";
                            break;

                        case ($f['temp_min'] < 50):
                            $prep = "just a shirt, shorts, and some sandals. ";
                            break;

                        default:
                            # code...
                            break;
                    }

                    $txt = "During " . explode(" ",$f['dt_txt'])[0] . " in the city of " . $f['city_name'] .
                    " you can expect " . $f['weather_desc'] . " with a minimum temperature of " . $f['temp_min'] ."C and a maximum temperature of "
                    . $f['temp_max'] . "C. The average humidity will be ".$f['humidity']." and the average pressure will be ".$f['pressure'].". We recommend wearing " . $prep."\n\n";

                    array_push($niz, $txt);
                    $forecastsForUser[$f['city_name']] = $niz;
                    $i++;
                }
            }

            $u = $user['user'];

            $cont = "Dear subscriber, \n\nYour daily forecast update for the next five days in your subscribed cities has arrived.\n\n";
            $cont = $cont . "____________________________________________________\n\n";
            foreach ($forecastsForUser as $fU) {
                $cont = $cont . $fU[0];
                $cont = $cont . $fU[1];
                $cont = $cont . $fU[2];
                $cont = $cont . $fU[3];
                $cont = $cont . $fU[4] . "\n\n" .
                "____________________________________________________\n\n";
            }
            $cont = $cont . "Thank you for using our service. \n\nRegards,\nPorgnozApp Team";

            Mail::raw($cont, function($message) use ($u){
                $message->to($u);
                $message->subject("Daily Forecast Update");
            });


        error_log("ffff");
        return 0;
    }
}
