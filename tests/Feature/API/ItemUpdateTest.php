<?php

namespace Tests\Feature\API;

use App\Models\Item;
use App\Services\CloudinaryService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $cloudinaryServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        // Mocking CloudinaryService to avoid calling the real service
        $this->cloudinaryServiceMock = $this->mock(CloudinaryService::class);
        $this->app->instance(CloudinaryService::class, $this->cloudinaryServiceMock);
    }

    public function test_update_item_with_image()
    {
        // Create a sample item
        $item = Item::factory()->create();

        // Mock the CloudinaryService::uploadMedia method to return a sample response
        $this->cloudinaryServiceMock
            ->shouldReceive('uploadMedia')
            ->once()
            ->andReturn(['secure_url' => 'https://example.com/image.jpg']);

        // Headers authorization
        $sampleCredentials = base64_encode('your_email@example.com:your_password');
        $headers = [
            'authorization' => "Basic $sampleCredentials",
        ];

        // Prepare update data
        $updateData = [
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ggBAykwo2MaGdsCnM5YYtpsBPruQp7UIRg&s',
        ];

        $response = $this->putJson('/api/items/'.$item->id, $updateData, $headers);

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

    public function test_throw_exceptions_during_upload_media()
    {
        // Create a sample item
        $item = Item::factory()->create();

        // Mock the CloudinaryService::uploadMedia method to return a sample response
        $this->cloudinaryServiceMock
            ->shouldReceive('uploadMedia')
            ->once()
            ->andThrowExceptions([new Exception('Connection refused', 521)]);

        // Headers authorization
        $sampleCredentials = base64_encode('your_email@example.com:your_password');
        $headers = [
            'authorization' => "Basic $sampleCredentials",
        ];

        // Prepare update data
        $updateData = [
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ggBAykwo2MaGdsCnM5YYtpsBPruQp7UIRg&s',
        ];

        // Send the update request
        $response = $this->putJson("/api/items/{$item->id}", $updateData, $headers);

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

    public function test_failed_authorization_to_update()
    {
        // Create a sample item
        $item = Item::factory()->create();

        // Headers add wrong authorization
        $wrongCredentials = base64_encode('wrong_email@example.com:wrong_password');
        $headers = [
            'authorization' => "Basic $wrongCredentials",
        ];

        // Prepare update data
        $updateData = [
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ggBAykwo2MaGdsCnM5YYtpsBPruQp7UIRg&s',
        ];

        // Send the update request
        $response = $this->putJson("/api/items/{$item->id}", $updateData, $headers);

        // Assert the response
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials',
            ]);

        // Assert the item is not updated in the database
        $updatedItem = Item::find($item->id);
        $this->assertEquals($item->imgUrl, $updatedItem->imgUrl);
    }

    public function test_no_basic_auth_to_update()
    {
        // Create a sample item
        $item = Item::factory()->create();

        // Unset headers authorization
        $headers = [];

        // Prepare update data
        $updateData = [
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ggBAykwo2MaGdsCnM5YYtpsBPruQp7UIRg&s',
        ];

        // Send the update request
        $response = $this->putJson("/api/items/{$item->id}", $updateData, $headers);

        // Assert the response
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Basic Auth not set',
            ]);

        // Assert the item is not updated in the database
        $updatedItem = Item::find($item->id);
        $this->assertEquals($item->imgUrl, $updatedItem->imgUrl);
    }
}
