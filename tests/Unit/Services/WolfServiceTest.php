<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Models\Item;
use App\Services\WolfService;
class WolfServiceTest extends TestCase
{

    /**
     * Unit test for update quality when SellIn is Positive and Quality less than 50
     */
    public function testUpdateQualityWhenSellInPositiveAndQualityLessThan50()
    {
        // Create test items
        $tempItem1 = new Item();
        $tempItem1->setBaseItem('Apple AirPods', 10, 40);
        $item1 = $tempItem1->getBaseItem();

        $tempItem2 = new Item();
        $tempItem2->setBaseItem('Apple iPad Air', 10, 40);
        $item2 = $tempItem2->getBaseItem();

        $tempItem3 = new Item();
        $tempItem3->setBaseItem('Samsung Galaxy S23', 10, 80);
        $item3 = $tempItem3->getBaseItem();

        $tempItem4 = new Item();
        $tempItem4->setBaseItem('Xiaomi Redmi Note 13', 10, 40);
        $item4 = $tempItem4->getBaseItem();

        $tempItem5 = new Item();
        $tempItem5->setBaseItem('Other Item Names', 10, 40);
        $item5 = $tempItem5->getBaseItem();

        // Create WolfService instance
        $service = new WolfService([$item1, $item2, $item3, $item4, $item5]);

        // Update quality and assert changes
        $service->updateQuality();

        $this->assertEquals(41, $item1->quality);
        $this->assertEquals(42, $item2->quality);
        $this->assertEquals(80, $item3->quality);
        $this->assertEquals(38, $item4->quality);
        $this->assertEquals(39, $item5->quality);

        $this->assertEquals(9, $item1->sellIn);
        $this->assertEquals(9, $item2->sellIn);
        $this->assertEquals(10, $item3->sellIn);
        $this->assertEquals(9, $item4->sellIn);
        $this->assertEquals(9, $item5->sellIn);
    }

    /**
     * Unit test for update quality when SellIn is Negative and Quality is less than 50
     */
    public function testUpdateQualityWhenSellInNegativeAndQualityLessThan50()
    {
        // Create test items
        $tempItem1 = new Item();
        $tempItem1->setBaseItem('Apple AirPods', -2, 40);
        $item1 = $tempItem1->getBaseItem();

        $tempItem2 = new Item();
        $tempItem2->setBaseItem('Apple iPad Air', -2, 40);
        $item2 = $tempItem2->getBaseItem();

        $tempItem3 = new Item();
        $tempItem3->setBaseItem('Samsung Galaxy S23', -20, 80);
        $item3 = $tempItem3->getBaseItem();

        $tempItem4 = new Item();
        $tempItem4->setBaseItem('Xiaomi Redmi Note 13', -2, 40);
        $item4 = $tempItem4->getBaseItem();

        $tempItem5 = new Item();
        $tempItem5->setBaseItem('Other Item Names', -2, 40);
        $item5 = $tempItem5->getBaseItem();

        // Create WolfService instance
        $service = new WolfService([$item1, $item2, $item3, $item4, $item5]);

        // Update quality and assert changes
        $service->updateQuality();

        $this->assertEquals(42, $item1->quality);
        $this->assertEquals(0, $item2->quality);
        $this->assertEquals(80, $item3->quality);
        $this->assertEquals(36, $item4->quality);
        $this->assertEquals(38, $item5->quality);

        $this->assertEquals(-3, $item1->sellIn);
        $this->assertEquals(-3, $item2->sellIn);
        $this->assertEquals(-20, $item3->sellIn);
        $this->assertEquals(-3, $item4->sellIn);
        $this->assertEquals(-3, $item5->sellIn);
    }

    /**
     * Unit test for update quality when SellIn is Positive and Quality equal 50
     */
    public function testUpdateQualityWhenSellInPositiveAndQualityEqual50()
    {
        // Create test items
        $tempItem1 = new Item();
        $tempItem1->setBaseItem('Apple AirPods', 10, 50);
        $item1 = $tempItem1->getBaseItem();

        $tempItem2 = new Item();
        $tempItem2->setBaseItem('Apple iPad Air', 10, 50);
        $item2 = $tempItem2->getBaseItem();

        $tempItem3 = new Item();
        $tempItem3->setBaseItem('Samsung Galaxy S23', 30, 80);
        $item3 = $tempItem3->getBaseItem();

        $tempItem4 = new Item();
        $tempItem4->setBaseItem('Xiaomi Redmi Note 13', 10, 50);
        $item4 = $tempItem4->getBaseItem();

        $tempItem5 = new Item();
        $tempItem5->setBaseItem('Other Item Names', 10, 50);
        $item5 = $tempItem5->getBaseItem();

        // Create WolfService instance
        $service = new WolfService([$item1, $item2, $item3, $item4, $item5]);

        // Update quality and assert changes
        $service->updateQuality();

        $this->assertEquals(50, $item1->quality);
        $this->assertEquals(50, $item2->quality);
        $this->assertEquals(80, $item3->quality);
        $this->assertEquals(48, $item4->quality);
        $this->assertEquals(49, $item5->quality);

        $this->assertEquals(9, $item1->sellIn);
        $this->assertEquals(9, $item2->sellIn);
        $this->assertEquals(30, $item3->sellIn);
        $this->assertEquals(9, $item4->sellIn);
        $this->assertEquals(9, $item5->sellIn);
    }

    /**
     * Unit test for update quality when SellIn is Negative and Quality equal 50
     */
    public function testUpdateQualityWhenSellInNegativeAndQualityEqual50()
    {
        // Create test items
        $tempItem1 = new Item();
        $tempItem1->setBaseItem('Apple AirPods', -2, 50);
        $item1 = $tempItem1->getBaseItem();

        $tempItem2 = new Item();
        $tempItem2->setBaseItem('Apple iPad Air', -2, 50);
        $item2 = $tempItem2->getBaseItem();

        $tempItem3 = new Item();
        $tempItem3->setBaseItem('Samsung Galaxy S23', -2, 80);
        $item3 = $tempItem3->getBaseItem();

        $tempItem4 = new Item();
        $tempItem4->setBaseItem('Xiaomi Redmi Note 13', -2, 50);
        $item4 = $tempItem4->getBaseItem();

        $tempItem5 = new Item();
        $tempItem5->setBaseItem('Other Item Names', -2, 50);
        $item5 = $tempItem5->getBaseItem();

        // Create WolfService instance
        $service = new WolfService([$item1, $item2, $item3, $item4, $item5]);

        // Update quality and assert changes
        $service->updateQuality();

        $this->assertEquals(50, $item1->quality);
        $this->assertEquals(0, $item2->quality);
        $this->assertEquals(80, $item3->quality);
        $this->assertEquals(46, $item4->quality);
        $this->assertEquals(48, $item5->quality);

        $this->assertEquals(-3, $item1->sellIn);
        $this->assertEquals(-3, $item2->sellIn);
        $this->assertEquals(-2, $item3->sellIn);
        $this->assertEquals(-3, $item4->sellIn);
        $this->assertEquals(-3, $item5->sellIn);
    }

}
