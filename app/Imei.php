<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imei extends Model
{
    protected $fillable = [
        'document_date', 'product', 'model', 'imei'
    ];

    public function scopeExclude($query,$value = array()) 
    {
        return $query->select( array_diff( $this->columns,(array) $value) );
    }
}
