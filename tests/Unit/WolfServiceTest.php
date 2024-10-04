<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Base\Item as BaseItem;
use App\Models\Item;
use App\Services\WolfService;
class WolfServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Unit test for update quality on AppleAirpods
     */
    public function testUpdateQualityOnAppleAirpods()
    {
        // Create test items
        $tempItem = new Item();
        $tempItem->setBaseItem('Apple AirPods', 10, 30);
        $item = $tempItem->getBaseItem();
        
        // Create WolfService instance
        $service = new WolfService([$item]);

        // Update quality and assert changes
        $service->updateQuality();

        $this->assertEquals(31, $item->quality); // Apple AirPods increases quality
    }

     /**
     * Unit test for update quality on AppleAirpods
     */
    public function testUpdateQualityOnXiaomiRedmiNote13()
    {
        // Create test items
        $tempItem = new Item();
        $tempItem->setBaseItem('Xiaomi Redmi Note 13', 10, 30);
        $item = $tempItem->getBaseItem();
        
        // Create WolfService instance
        $service = new WolfService([$item]);

        // Update quality and assert changes
        $service->updateQuality();

        $this->assertEquals(28, $item->quality); // Apple AirPods increases quality
    }

}
