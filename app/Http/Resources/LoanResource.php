<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LoanResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'customer_name' => !empty($this->user_id)?$this->users->first_name.' '.$this->users->last_name:'-',
            'amount' =>$this->loan_amt,
            'tenor '=>$this->loan_tenor,
            'status' => $this->status,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
