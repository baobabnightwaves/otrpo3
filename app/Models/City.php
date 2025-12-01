<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'coat_of_arms_image',
        'card_text',
        'modal_title',
        'modal_text',
        'city_image',
        'wiki_url',
        'interesting_fact'
    ];
}