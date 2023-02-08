<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class W_category extends Model
{
    use HasFactory;

    public function getSubcategory()
    {

        return $this->hasMany(Subcategory::class, 'category_id', 'id');

    }
}
