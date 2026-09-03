<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coach extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table= 'coaches';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coachHistory()
    {
        return $this->hasMany(CoachHistory::class);
    }

    public function coachNotes()
    {
        return $this->hasMany(CoachNote::class);
    }
}
