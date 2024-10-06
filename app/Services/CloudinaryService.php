<?php

namespace App\Services;

use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class CloudinaryService
{
    private $config;

    public function __construct()
    {
        $this->setConfiguration();
    }

    private function setConfiguration()
    {
        $configData = config('services.cloudinary');
        $this->config = new Configuration;
        $this->config->cloud->cloudName = $configData['cloud_name'];
        $this->config->cloud->apiKey = $configData['api_key'];
        $this->config->cloud->apiSecret = $configData['api_secret'];
    }

    public function getConfiguration(): Configuration
    {
        return $this->config;
    }

    public function uploadMedia($file, array $options = []): ApiResponse
    {
        try {
            $uploadApi = new UploadApi($this->config);
            $result = $uploadApi->upload($file, $options);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $result;
    }
}
