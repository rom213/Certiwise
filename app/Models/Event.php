<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Event extends Model
{
    use HasSlug, HasFactory, BelongsToTenant;

    protected $fillable = ['title', 'collection_id', 'description', 'start_date', 'end_date', 'attributes'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function images(): BelongsToMany {
        return $this->belongsToMany(Image::class)->withTimestamps();
    }

    public function recipients(): BelongsToMany {
        return $this->belongsToMany(Recipient::class)->withPivot(['user_data', 'id'])->withTimestamps();
    }

    public function certificate(): HasOne {
        return $this->hasOne(Certificate::class);
    }

    public function viewPage()
    {
        return $this->hasOne(ViewPage::class);
    }

    public function email(): HasOne {
        return $this->hasOne(Email::class);
    }
}
