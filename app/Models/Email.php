<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'email_header_id',
        'email_styles_id',
        'header_color',
        'image_logo',
        'body',
        'button_color',
        'button_text',
        'footer_text',
        'helper_text',
    ];
}
