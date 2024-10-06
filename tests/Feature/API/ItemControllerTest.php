<?php

namespace Tests\Feature\API;

use App\Models\Item;
use App\Services\CloudinaryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_update_item_with_image()
    {
        // Create a sample item
        $item = Item::factory()->create();
        // Prepare update data
        $updateData = [
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ggBAykwo2MaGdsCnM5YYtpsBPruQp7UIRg&s',
        ];

        // Mock the CloudinaryService::uploadMedia method to return a sample response
        $this->mock(CloudinaryService::class)
            ->shouldReceive('uploadMedia')
            ->once()
            ->andReturn(['secure_url' => 'https://example.com/image.jpg']);

        // Send the update request
        $response = $this->putJson("/api/items/{$item->id}", $updateData);
        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'message' => 'Updated successfully!',
            ]);

        // Assert the updated item in the database
        $updatedItem = Item::find($item->id);
        $this->assertEquals('https://example.com/image.jpg', $updatedItem->imgUrl);
    }

    public function test_failed_response_during_upload_media()
    {
        // Create a sample item
        $item = Item::factory()->create();
        // Prepare update data
        $updateData = [
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ggBAykwo2MaGdsCnM5YYtpsBPruQp7UIRg&s',
        ];

        // Mock the CloudinaryService::uploadMedia method to return a sample response
        $this->mock(CloudinaryService::class)
            ->shouldReceive('uploadMedia')
            ->once()
            ->andThrowExceptions(['message' => 'Connection refused', 'code' => 521]);

        // Send the update request
        $response = $this->putJson("/api/items/{$item->id}", $updateData);

        // Assert the response
        $response->assertStatus(500)
            ->assertJson([
                'code' => 521,
                'message' => 'Connection refused',
            ]);

        // Assert the item is not updated in the database
        $updatedItem = Item::find($item->id);
        $this->assertEquals($item->imgUrl, $updatedItem->imgUrl);
    }
}
