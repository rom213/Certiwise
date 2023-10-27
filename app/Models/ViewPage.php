<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'certificate_name',
        'event_description',
        'criteria_for_obtaining'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }


}
