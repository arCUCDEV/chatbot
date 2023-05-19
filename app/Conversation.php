<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversation';
    protected $fillable = [
        'user_identification', 'conversation'
        ];
    protected $primaryKey = 'id_conversation';
}
