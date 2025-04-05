<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug'];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tag) {
            $tag->slug = $tag->slug ?? Str::slug($tag->name);
        });
    }
    
    /**
     * Get the events that are assigned this tag.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
    
    /**
     * Get the users that follow this tag.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
