<?php

namespace App\Models;

use App\Models\Traits\ModelAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepaymentType extends BaseModel
{
    use ModelAttributes, SoftDeletes;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'repayment_types';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
}
