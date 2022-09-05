<?php

namespace App\Models\Traits\Relationships;

use App\Models\Auth\User;

trait LoanRelationships
{
    /**
     * Loans belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * User updated by User.
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
