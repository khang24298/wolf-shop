<?php

namespace App\Services;

use Cloudinary\Api\ApiResponse;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
class CloudinaryService{

    // public $cloud_name;
    // public $api_key;
    // public $api_secret;
    private $config;
    public function __construct(){
		$this->setConfiguration();
    }
	private function setConfiguration() {
		$this->config = new Configuration();
        // $this->config->cloud->cloudName = $this->cloud_name;
        // $this->config->cloud->apiKey = $this->api_key;
        // $this->config->cloud->apiSecret = $this->api_secret;
		$this->config->cloud->cloudName = env('CLOUDINARY_CLOUD_NAME');
        $this->config->cloud->apiKey = env('CLOUDINARY_API_KEY');
        $this->config->cloud->apiSecret = env('CLOUDINARY_API_SECRET');
	}

    public function uploadMedia($file, array $options = []): ApiResponse{
		try {
			$uploadApi = new UploadApi($this->config);
			$result = $uploadApi->upload($file, $options);
		} catch (\Throwable $th) {
			throw $th;
		}
        return $result;
    }
}