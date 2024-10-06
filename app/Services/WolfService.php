<?php

declare(strict_types=1);

namespace App\Services;
use App\Models\Item;
final class WolfService
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) { }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
			if ($item->name === 'Samsung Galaxy S23') {
				// Do not change anything if product is Samsung Galaxy S23
				continue;
			}
			// Ensure the input item quality value: 0 < quality =< 50
			$item->quality = $item->quality >= 50 ? 50 : max(0, $item->quality);
			$item->sellIn--;
			switch ($item->name) {
				case 'Xiaomi Redmi Note 13':
					$qualityDegrade = $item->sellIn < 0 ? 4 : 2;
					$item->quality = max(0, $item->quality - $qualityDegrade);
					break;
				case 'Apple AirPods':
					$qualityDegrade = $item->sellIn < 0 ? 2 : 1;
					$item->quality = min(50, $item->quality + $qualityDegrade);
					break;
				case 'Apple iPad Air':
					$item->quality += $item->sellIn < 11 ? 1 : 0;
					$item->quality += $item->sellIn < 6 ? 1 : 0;
					$item->quality = $item->sellIn < 0 ? 0 : min(50, $item->quality + 1);
					break;
				default:
					# quality degrades for others
					$qualityDegrade = $item->sellIn < 0 ? 2 : 1;
					$item->quality = max(0, $item->quality - $qualityDegrade);
					break;
			}
        }
    }
}