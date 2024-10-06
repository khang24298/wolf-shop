<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Base\Item as BaseItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    private $baseItem;

    protected $fillable = [
        'name',
    ];

    protected $primaryKey = 'id';

    public function getBaseItem()
    {
        return $this->baseItem;
    }

    public function setBaseItem(string $name, int $sellIn, int $quality)
    {
        $this->baseItem = new BaseItem($name, $sellIn, $quality);
    }
}
