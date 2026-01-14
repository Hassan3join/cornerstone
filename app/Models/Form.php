<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $guarded = [];
    public function items()
    {
        return $this->hasMany(FormItem::class)->orderBy('order_index', 'asc')->with(['question']);
    }
}
