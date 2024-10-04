<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemUpdateRequest;
use App\Services\CloudinaryService;
class ItemController extends Controller
{
    public function __construct(){
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
        if (!$item){
            return response()->json(['message' => 'Item not found'], 404);
        }

        $cloudinaryService = new CloudinaryService();
        try {
            $response = $cloudinaryService->uploadMedia($request['image']);
            $item->img_url = $response['secure_url'];
            $item->quality = $request['quality'] ?? $item->quality;
            $item->sell_in = $request['sell_in'] ?? $item->sellIn;
            $item->save();
            $message = 'Updated successfully!';
            $code = 0; // 0: success
            $statusCode = 200;
        } catch (\Exception $e){
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
