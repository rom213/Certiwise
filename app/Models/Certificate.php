<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Certificate extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = ['data', 'event_id'];
    protected $casts = ['data' => 'array'];
}
