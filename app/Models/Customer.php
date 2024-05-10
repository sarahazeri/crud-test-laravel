<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function toResponse()
    {
        return [
            "id" => $this->id,
            "firstName" => $this->first_name,
            "lastName" => $this->last_name,
            "dateOfBirth" => $this->date_of_birth,
            "prefixPhoneNumber" => $this->prefix_phone_number,
            "phoneNumber" => $this->phone_number,
            "email" => $this->email,
            "bankAccountNumber" => $this->bank_account_number,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];
    }
}
