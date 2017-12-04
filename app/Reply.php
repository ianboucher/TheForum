<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function favorite() 
    {
        $attributes = ['user_id' => auth()->id()];
        if(!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);            
        }
    }
}
