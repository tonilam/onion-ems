<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Contact extends Model
{
    use HasFactory;

    // A contact may be an address
    public function address(): Relation
    {
        return $this->belongsTo(Address::class);
    }
}
