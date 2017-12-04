<?php

namespace App\Filters;

use App\User;
use App\Filters\Filter;
use Illuminate\Http\Request;

class ThreadFilters extends Filter
{
    protected $filters = ['by', 'popular'];

    /**
     * Filter the query by a given username
     * 
     * @param $builder
     * @param {string} $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter threads by popularity
     * 
     * @param $builder
     * @param {string} $username
     * @return mixed
     */
    public function popular()
    {
        // remove exisiting order_by before applying new order
        $this->builder->getQuery()->orders = [];
        
        return $this->builder->orderBy('replies_count', 'desc');
    }
}