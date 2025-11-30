<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * * Spatie Media Library usually handles mass assignment, but for a custom model:
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'uuid',
        'collection_name',
        'name',
        'file_name',
        'mime_type',
        'disk',
        'conversions_disk',
        'size',
        'manipulations',
        'custom_properties',
        'generated_conversions',
        'responsive_images',
        'order_column',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'manipulations' => 'array',
        'custom_properties' => 'array',
        'generated_conversions' => 'array',
        'responsive_images' => 'array',
        'order_column' => 'integer',
        'size' => 'integer',
    ];

    /**
     * Get the parent model (post, user, etc.) that the media belongs to.
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
