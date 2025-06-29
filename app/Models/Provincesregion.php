<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincesregion extends Model
{
    use HasFactory;

    public function airports()
    {
        return $this->hasMany(Airport::class);
    }
}
