<?php

namespace App\Console\Commands;

use App\Http\Controllers\GoldController;
use App\Models\GoldPriceChart;
use DateTime;
use DateTimeZone;
use Illuminate\Console\Command;

class CreateRecordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:gold-price-chart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'every day create new recorde to the gold price charts table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $json = file_get_contents('https://data-asg.goldprice.org/dbXRates/USD');
        $decoded = json_decode($json);
        $item = $decoded->items;
        $gold_price = $item[0]->xauPrice / 31.1034768;

        $date = new DateTime('now', new DateTimeZone('Asia/Damascus'));
        $model = new GoldPriceChart();
        $model->create([
            'gold_price' =>$gold_price,
            'date' => $date,
        ]);



    }
}
