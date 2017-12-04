<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    protected static function boot() 
    {
        parent::boot();

        // for all Thread queries apply this queryScope to add count
        static::addGlobalScope('replyCount', function($builder) {
            $builder->withCount('replies');
        });
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
