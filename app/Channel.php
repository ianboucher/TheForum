<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Get the route key name for Laravel.
     * Tells Laravel to fetch the model by slug column instead of Id
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    /**
     * A channel consists of threads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
