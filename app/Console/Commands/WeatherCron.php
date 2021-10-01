<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use stdClass;

class WeatherCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weather data retrieval.';

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
        $client = new \GuzzleHttp\Client();
        
        $url_r = "http://127.0.0.1:8000/api/reports";
        $url_c = "http://127.0.0.1:8000/api/cities";
        $url_u = "http://127.0.0.1:8000/api/users";

        //Uzimanje unikatnih gradova na koje su korisnici prijavljeni
        $res = $client->request('GET', $url_c."/city_name");
        $gradovi = json_decode($res->getBody(), true);
        //error_log($gradovi[0]['city_name']);
        $niz['city_name'] = [];

        //uzimanje prognoza prognoza iz weatherapi za svaki grad i unosenje u bazu
        foreach ($gradovi as $g) {
            array_push($niz['city_name'],$g['city_name']);
            $url = 'https://api.openweathermap.org/data/2.5/forecast?q='.$g['city_name'].'&appid=283ffcd4756f546f71f2e37f52c59bd9&units=metric';
            $res = $client->request('GET', $url, ['verify' => false]);
            $content = json_decode($res->getBody(), true);
            $arrFore = $content["list"];

            for ($i=0; $i < count($arrFore) ; $i+=8) { 
                $forecast = new stdClass;
                $forecast->city_name = $content["city"]["name"];
                $forecast->country = $content["city"]["country"];
                $forecast->weather_name = $arrFore[$i]["weather"][0]["main"];
                $forecast->weather_desc = $arrFore[$i]["weather"][0]["description"];
                $forecast->temp_min = $arrFore[$i]["main"]["temp_min"];
                $forecast->temp_max = $arrFore[$i]["main"]["temp_max"];
                $forecast->humidity = $arrFore[$i]["main"]["humidity"];
                $forecast->pressure = $arrFore[$i]["main"]["pressure"];
                $forecast->dt_txt = $arrFore[$i]["dt_txt"];
    
                $t = $client->request('POST', $url_r, ['json' => ['forecast' => $forecast]]);
  
            }
        }

        
        //$t = $client->request('GET', $url_r, ['json' => ['forecast' => $forecast]]);


        //uzimanje prognoza za izabrane gradove iz naseg API-a
        $res = $client->request('GET', $url_r, ['query' => $niz]);
        $forecasts = json_decode($res->getBody(), true);

        //uzimanje korisnik
        $res = $client->request('GET', $url_u);
        $users = json_decode($res->getBody(), true);

        foreach ($users as $user) {
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
                    . $f['temp_max'] . "C. We recommend wearing " . $prep."\n\n";
                    
                    array_push($niz, $txt);
                    $forecastsForUser[$f['city_name']] = $niz;
                    $i++;
                }
            }

            //TESTIRANJE
            //foreach ($forecastsForUser as $key => $value) {
            //    error_log($key);
            //}
            //error_log(count($forecastsForUser));
            //error_log('-----------------------------------');

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
            
        }

        //$data = ['name'=>'Marko', 'data'=>'Pozdrav!'];
        /*$user ='marko.vuko@gmail.com';

        Mail::raw(json_encode($arr), function($message) use ($user){
            $message->to($user);
            $message->subject("test poruka");
        });
        */

        
        
        return 0;
    }
}
