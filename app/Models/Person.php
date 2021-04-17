<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use PhpParser\Node\Scalar\String_;

class Person extends Model
{
    use HasFactory;

    // Many client may belongs to the same person (e.g. multiple account for different purposes)
    public function clients(): Relation
    {
        return $this->hasMany(Client::class);
    }

    public function getFullName(): String
    {
        return $this->first_name . ' ' . ($this->middle_name ? ' ' . substr($this->middle_name, 0, 1) : '') . $this->last_name;
    }
}
