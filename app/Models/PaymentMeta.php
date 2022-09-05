<?php

namespace App\Models;

use App\Models\Traits\ModelAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMeta extends BaseModel
{
    use ModelAttributes, SoftDeletes;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'payment_metas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
}
