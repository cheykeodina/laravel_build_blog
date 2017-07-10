<?php
/**
 * Created by PhpStorm.
 * User: keodina
 * Date: 7/10/17
 * Time: 11:02 AM
 */

namespace App\Filters;


use App\User;

class ThreadFilters extends Filters
{

    protected $filters = ['by', 'popular'];

    /**
     * @param $username
     * @return mixed
     * @internal param $builder
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    protected function popular()
    {
        // reset order
        $this->builder->getQuery()->orders = [];
        // override the order with replies_count
        return $this->builder->orderBy('replies_count', 'DESC');
    }
}