<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MatchUserModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    public $timestamps = false;
    protected $table = 'match_user';

    protected $fillable = [
        'id',
        'matchid',
        'userid',
    ];

}