<?php

namespace Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use App\Models\Item;
use App\Helpers\ItemHelper;
class ItemHelperTest extends TestCase
{
    public function testMappingRawDataToItemWithoutPriceAndSellIn(){
        // Sample rawItem
		$sampleRawItem = [
			'id' => '1',
			'name' => 'Google Pixel 6 Pro',
			'data' => [
				'color' => 'Cloudy White',
				'capacity' => '128 GB'
			]
		];
		$mappedItem= ItemHelper::mappingRawDataToItem($sampleRawItem);
		$expectedItem = [
			'name' 		=> 'Google Pixel 6 Pro',
			'quality' 	=> 0, 
			'sellIn' 	=> 0, 
			'imgUrl' 	=> null
		];
		$this->assertEquals($expectedItem, $mappedItem);
    }

	public function testMappingRawDataToItemWithPrice(){
		// Sample rawItem
		$sampleRawItem = [
			'id' => '1',
			'name' => 'Google Pixel 6 Pro',
			'data' => [
				'color' => 'Cloudy White',
				'capacity' => '128 GB',
				'Price'  => '128.50'
			]
		];
		$mappedItem= ItemHelper::mappingRawDataToItem($sampleRawItem);
		$expectedItem = [
			'name' 		=> 'Google Pixel 6 Pro',
			'quality' 	=> 128, 
			'sellIn' 	=> 0, 
			'imgUrl' 	=> null
		];
		$this->assertEquals($expectedItem, $mappedItem);
	}

	public function testMappingRawDataToItemWithSellIn(){
		// Sample rawItem
		$sampleRawItem = [
			'id' => '1',
			'name' => 'Google Pixel 6 Pro',
			'data' => [
				'color' => 'Cloudy White',
				'capacity' => '128 GB',
				'year'  => 2019
			]
		];
		$mappedItem= ItemHelper::mappingRawDataToItem($sampleRawItem);
		$expectedItem = [
			'name' 		=> 'Google Pixel 6 Pro',
			'quality' 	=> 0, 
			'sellIn' 	=> 5*365, 
			'imgUrl' 	=> null
		];
		$this->assertEquals($expectedItem, $mappedItem);
	}
}
