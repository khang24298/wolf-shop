<?php

namespace App\Services;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class CloudinaryService
{
    private $config;

    private $uploadApi;

    public function __construct()
    {
        $this->setConfiguration();

        // Set config for uploadApi
        $this->uploadApi = new UploadApi($this->config);
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

    public function uploadMedia($file, array $options = [])
    {
        try {
            $result = $this->uploadApi->upload($file, $options);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $result;
    }
}
