<?php

namespace App\Models;

use App\Models\Traits\ModelAttributes;
use App\Models\Traits\Relationships\LoanRelationships;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends BaseModel
{
    use ModelAttributes, SoftDeletes, LoanRelationships;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'loans';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
}
