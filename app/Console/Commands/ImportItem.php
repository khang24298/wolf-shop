<?php

namespace App\Console\Commands;

use App\Helpers\ItemHelper;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Item;
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
        $code = 0; // 0: success
        $configImport = config('services.import_items');
        $uriImport = $configImport['host'].$configImport['path'];
        try {
            $response = $client->get($uriImport);
            $data = json_decode($response->getBody(), true);
            foreach ($data as $itemData) {
                $itemConverted = ItemHelper::mappingRawDataToItem($itemData);
                $item = Item::where('name', '=', $itemConverted['name'])->first();
                if (!empty($item)) {
                    // Update quality if exist
                    $item->quality = $itemConverted['quality'];
                    $item->save();
                } else {
                    // Create new item
                    Item::create($itemConverted);
                }
            }
            $this->info('Items imported successfully!');
        } catch(\Exception $e){
            $this->error($e->getMessage());
            $code = $e->getCode();
        }
        return $code;
    }
}
