<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $table = 'shop_products';

    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'selling_price',
        'image_url',
        'stock',
    ];

    /**
     * Always return a proper absolute URL for the product image.
     * Handles both legacy "/storage/products/..." paths and clean "products/..." paths.
     */
    public function getImageUrlAttribute($value): ?string
    {
        if (!$value) return null;

        // If already a full URL, return as-is
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        // Strip any leading /storage/ prefix (legacy format)
        $relativePath = ltrim($value, '/');
        if (str_starts_with($relativePath, 'storage/')) {
            $relativePath = substr($relativePath, strlen('storage/'));
        }

        // Use Laravel Storage to generate the correct URL (respects APP_URL + subdirectory)
        return Storage::disk('public')->url($relativePath);
    }
}

