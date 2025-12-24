<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'coat_of_arms_image',
        'card_text',
        'modal_title',
        'modal_text',
        'city_image',
        'wiki_url',
        'interesting_fact',
        'user_id'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = ['user_id' => 'int']; 

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected static function booted()
    {
        static::creating(function ($city) {
            if (!Auth::check())
                abort(401);

            $city->user_id = Auth::id();
        });
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(ucfirst($value));
    }

    public function setWikiUrlAttribute($value)
    {
        if (!empty($value) && !preg_match('/^https?:\/\//', $value)) {
            $value = 'https://' . $value;
        }
        $this->attributes['wiki_url'] = trim($value);
    }

    public function setCardTextAttribute($value)
    {
        $this->attributes['card_text'] = substr(trim($value), 0, 500);
    }

    public function setInterestingFactAttribute($value)
    {
        $value = trim($value);
        if (!empty($value) && substr($value, -1) !== '!') {
            $value .= '!';
        }
        $this->attributes['interesting_fact'] = $value;
    }

    public function getCoatOfArmsImageUrlAttribute()
    {
        if ($this->coat_of_arms_image) {
            return asset('storage/' . $this->coat_of_arms_image);
        }
        return null;
    }

    public function getCityImageUrlAttribute()
    {
        if ($this->city_image) {
            return asset('storage/' . $this->city_image);
        }
        return null;
    }
}