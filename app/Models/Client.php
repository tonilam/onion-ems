<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property string name
 * @property string status
 */
class Client extends Model
{
    use HasFactory;

    // A client may representing a company
    public function company(): Relation
    {
        return $this->belongsTo(Company::class);
    }

    // A client may be an individual
    public function person(): Relation
    {
        return $this->belongsTo(Person::class);
    }

}
