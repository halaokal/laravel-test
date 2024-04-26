<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MatchModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    public $timestamps = false;
    protected $table = 'matches';

    protected $fillable = [
        'id',
        'name',
        'date',
        'location',
        'trainerid'
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'match_user')->withPivot('role')->wherePivot('role', 0);
    }
}
