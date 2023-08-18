<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'values' => 'array',
    ];

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type_id', 'values'];

    protected $primaryKey = 'id';

    protected $with = ['type'];

    /**
    * Get the user's largest order.
    */
    public function type(): HasOne
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }



}
