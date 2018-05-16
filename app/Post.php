<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'content',
        'rate',
        'type',
    ];

    /**
     * Post Belong To User
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Post Belong To OrderDetail
     *
     * @return mixed
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}