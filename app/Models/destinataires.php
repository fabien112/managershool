<?php

namespace App\Models;

use App\Models\User;
use App\Models\messages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class destinataires extends Model
{
    use HasFactory;

    protected $fillable = [

        'messages_id',
        'liste_destinataire',
        'liste_dest',
        'user_id',
        'session',
        'codeEtab',
        'type_destinataire'
    ];


    public function messages () {
        return $this->belongsTo(messages::class);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

}
