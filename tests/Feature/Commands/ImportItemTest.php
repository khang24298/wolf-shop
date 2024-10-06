<?php

namespace Tests\Feature\Commands;

use App\Console\Commands\ImportItem;
use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImportItemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSuccessfulImport()
    {
        // Mock external dependencies
        $client = $this->mock(Client::class);
        $client->shouldReceive('get')
            ->once()
            ->andReturnSelf();
        $client->shouldReceive('get')
            ->once()
            ->andReturn('{"items":[{"name":"Test Item", "quality":10}]}');

        // Run the command
        $command = new ImportItem;
        $exitCode = $command->handle();

        // Assert the result
        $this->assertEquals(0, $exitCode);
        // $this->expectOutputString('Items imported successfully!');
    }

    public function testImportWithExistingItem()
    {
        // ... (similar setup as above)

        // Mock Item::where to return an existing item
        Item::shouldReceive('where')
            ->once()
            ->with('name', '=', 'Test Item')
            ->andReturnSelf();
        Item::shouldReceive('first')
            ->once()
            ->andReturn(Item::factory()->create(['name' => 'Test Item']));

        // ... (rest of the test)
    }

    public function testFailedImport()
    {
        // ... (similar setup as above)

        // Mock the client to throw an exception
        $client->shouldReceive('get')->andThrowException(new \Exception('API error'));

        // ... (rest of the test)
    }
}
