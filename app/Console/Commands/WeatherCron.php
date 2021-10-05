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



        return 0;
    }
}
