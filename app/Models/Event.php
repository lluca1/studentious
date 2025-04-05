<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'creator_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the user that created the event.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the users attending this event.
     */
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }
    
    /**
     * Get the curricula associated with this event.
     */
    public function curricula()
    {
        return $this->hasMany(Curriculum::class);
    }

    /**
     * Get the messages associated with this event.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the tags for this event.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}