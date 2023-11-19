<?php

namespace App\MediaLibrary;

use App\Models\Client;
use App\Models\ProductType;
use App\Models\JobRequest;
use App\Models\Product;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 * @package App\MediaLibrary
 */
class CustomPathGenerator implements PathGenerator
{
    /**
     * @param Media $media
     *
     * @return string
     */
    public function getPath(Media $media): string
    {
        switch ($media->model_type) {

            case ProductType::class:
                return ProductType::PATH . '/' . $media->id . '/';
                break;
            case Client::class:
                return Client::PATH . '/' . $media->id . '/';
                break;
            case User::class:
                return User::PATH . '/' . $media->id . '/';
                break;
            case Product::class:
                return Product::PATH . '/' . $media->id . '/';
                break;
            case JobRequest::class:
                return JobRequest::PATH . '/' . $media->id . '/';
                break;
            default:
                return $media->id . '/';
        }
    }

    /**
     * @param Media $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'thumbnails/';
    }

    /**
     * @param Media $media
     *
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'rs-images/';
    }
}
