<?php

namespace Tests\Unit\Services;

use App\Services\CloudinaryService;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Tests\TestCase;

class CloudinaryServiceTest extends TestCase
{
    public function testUploadMedia()
    {
        // Mock Cloudinary configuration
        $configData = [
            'cloud_name' => 'your_cloud_name',
            'api_key' => 'your_api_key',
            'api_secret' => 'your_api_secret',
        ];

        config()->set('services.cloudinary', $configData);

        // Mock UploadApi
        $this->mock(UploadApi::class)
            ->shouldReceive('upload')
            ->with('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ggBAykwo2MaGdsCnM5YYtpsBPruQp7UIRg&s', [])
            ->andReturn(['secure_url' => 'https://example.com/image.jpg']);

        // Mock Configuration::class
        $config = $this->mock(Configuration::class);
        $config->shouldReceive('cloud')->andReturnSelf();
        $config->shouldReceive('cloudName')->andReturn($configData['cloud_name']);
        $config->shouldReceive('apiKey')->andReturn($configData['api_key']);
        $config->shouldReceive('apiSecret')->andReturn($configData['api_secret']);

        // Create CloudinaryService instance
        $cloudinaryService = new CloudinaryService();

        // Assert that configuration is set correctly
        $this->assertEquals($configData['cloud_name'], $cloudinaryService->getConfiguration()->cloud->cloudName);
        $this->assertEquals($configData['api_key'], $cloudinaryService->getConfiguration()->cloud->apiKey);
        $this->assertEquals($configData['api_secret'], $cloudinaryService->getConfiguration()->cloud->apiSecret);

        // // Call uploadMedia method
        $result = $cloudinaryService->uploadMedia('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ggBAykwo2MaGdsCnM5YYtpsBPruQp7UIRg&s');

        // // Assert the result
        $this->assertEquals('https://example.com/image.jpg', $result['secure_url']);
    }

    public function testUploadMediaException()
    {
        // Mock UploadApi to throw an exception
        $this->mock(UploadApi::class)
            ->shouldReceive('upload')
            ->andThrowException(new \Exception('Upload failed'));

        // Create CloudinaryService instance
        $cloudinaryService = new CloudinaryService();

        // Test exception handling
        $this->expectException(\Exception::class);
        $cloudinaryService->uploadMedia('path/to/file.jpg');
    }
}