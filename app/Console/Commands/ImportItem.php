<?php

namespace App\Console\Commands;

use App\Helpers\ItemHelper;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
class ImportItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-item';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $code = 0; // 0: success, 1: error
        try {
            $response = $client->get('https://api.restful-api.dev/objects');
            $data = json_decode($response->getBody(), true);
            foreach ($data as $itemData) {
                $itemConverted = ItemHelper::mappingRawDataToItem($itemData);
                $item = Item::where('name', '=', $itemConverted['name'])->first();
                if (!empty($item)) {
                    $item->quality = $itemConverted['quality'];
                    $item->save(); // Update quality if exist
                } else {
                    Item::create($itemConverted); // Create new item
                }
            }
            $this->info('Items imported successfully!');
        } catch(\Exception $e){
            $this->error($e->getMessage());
            $code = 1;
        }
        return $code;
    }
}
