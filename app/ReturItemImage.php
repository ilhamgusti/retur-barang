<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturItemImage extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_url',
        'retur_id',
        'keterangan'
    ];

    public function returItem()
    {
        return $this->belongsTo(ReturItem::class, 'retur_id', 'id');
    }
}
