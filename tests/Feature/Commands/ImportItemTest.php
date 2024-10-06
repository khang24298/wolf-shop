<?php

namespace Tests\Unit\Commands;

use App\Console\Commands\ImportItem;
use App\Helpers\ItemHelper;
use App\Models\Item;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ImportItemTest extends TestCase
{
    use RefreshDatabase;
    protected $clientMock;
    protected function setUp(): void
    {
        parent::setUp();
        // Mocking the Guzzle HTTP Client
        $this->clientMock = $this->mock(Client::class);
        // Binding the mocks into the application container
        $this->app->instance(Client::class, $this->clientMock);
    }

    /** @test */
    public function test_items_import_successfully()
    {
        // Arrange
        $importedData = [
            ['name' => 'Item 1', 'data' => ['price' => 10]],
            ['name' => 'Item 2', 'data' => ['price' => 3]],
        ];

        $mappedData1 = ItemHelper::mappingRawDataToItem($importedData[0]);
        $mappedData2 = ItemHelper::mappingRawDataToItem($importedData[1]);

        // Mock Guzzle HTTP response
        $responseMock = new Response(200, [], json_encode($importedData));
        $this->clientMock->shouldReceive('get')
            ->once()
            ->andReturn($responseMock);

        // Create an Item for the first entry
        Item::factory()->create(['name' => $mappedData1['name'], 'quality' => 5]);
        // var_dump(Item::all());
        $this->artisan(ImportItem::class)
            ->expectsOutput('Items imported successfully!')
            ->assertExitCode(0);
        
        // Assert that the first item was updated and the second was created
        $this->assertDatabaseHas('items', [
            'name' => 'Item 1',
            'quality' => 10, // The quality should have been updated
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Item 2',
            'quality' => 3, // The second item should have been created
        ]);
    }

    /** @test */
    public function test_import_fails_due_to_exception()
    {
        // Arrange
        $exceptionMessage = 'Connection failed';

        // Mock Guzzle to throw an exception
        $this->clientMock->shouldReceive('get')
            ->once()
            ->andThrowExceptions([new \Exception($exceptionMessage, 521)]);

        // Act
        $this->artisan(ImportItem::class)
            ->expectsOutput($exceptionMessage)
            ->assertExitCode(521);  // Non-zero exit code for failure
    }
}
