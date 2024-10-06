<?php

namespace App\Helpers;

class ItemHelper
{
    public static function mappingRawDataToItem(array $rawItem): array
    {
        $rawItemData = $rawItem['data'];
        $rawPrice = $rawItemData['Price'] ?? $rawItemData['price'] ?? 0;
        $rawDate = $rawItemData['year'] ?? date('Y');
        $item = [
            'name' => $rawItem['name'],
            'quality' => min(50, (int) $rawPrice), // As the API response doesn't have quality field, I assume it will be [data][Price] field
            'sellIn' => (date('Y') - (int) $rawDate) * 365, // As the API response doesn't have sellIn field, I assume it will be [data][year] field with my method
            'imgUrl' => null,
        ];

        return $item;
    }
}
