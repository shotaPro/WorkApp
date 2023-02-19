<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work_consult_message extends Model
{
    use HasFactory;

    public function get_reply_message()
    {
        return $this->hasMany(Work_consult_message::class, 'receiver_id');
    }
}
