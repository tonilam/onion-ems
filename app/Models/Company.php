<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Company extends Model
{
    use HasFactory;

    // Many client may belongs to the same company
    public function clients(): Relation
    {
        return $this->hasMany(Client::class);
    }

}
