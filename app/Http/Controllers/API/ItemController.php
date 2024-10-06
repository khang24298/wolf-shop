<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Item;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemUpdateRequest $request, int $id)
    {
        $item = Item::find($id);
        if (! $item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        try {
            $response = $this->cloudinaryService->uploadMedia($request['image']);
            $item->imgUrl = $response['secure_url'];
            $item->quality = $request['quality'] ?? $item->quality;
            $item->sellIn = $request['sell_in'] ?? $item->sellIn;
            $item->save();
            $message = 'Updated successfully!';
            $code = 0; // 0: success
            $statusCode = 200;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            $statusCode = 500;
        }

        return response()->json(['code' => $code, 'message' => $message, 'data' => $item], $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
