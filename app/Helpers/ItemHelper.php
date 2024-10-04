<?php

namespace App\Helpers;


class ItemHelper
{
    public static function mappingRawDataToItem(array $rawItem): array{
        $rawItemData = $rawItem['data'];
        $rawPrice = $rawItemData['Price'] ?? 0;
        $item = [
            'name' => $rawItem['name'],
            'quality' => (int)$rawPrice, // As the API response doesn't have quality field, I assume it will be [data][Price] field
            'img_url' => null
        ];
        return $item;
    }
}
