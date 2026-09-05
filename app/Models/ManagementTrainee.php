<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManagementTrainee extends Model
{
    use HasUuids;    
    use HasFactory;

    protected $table= 'management_trainees';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mtProgram()
    {
        return $this->belongsTo(MtProgram::class, 'mt_program_id');
    }


    public function assignment()
    {
        return $this->hasMany(Assignment::class, 'mt_id');
    }

    public function mtStatusLog()
    {
        return $this->hasMany(MtStatusLog::class);
    }

    public function coachNote()
    {
        return $this->hasMany(CoachNote::class, 'mt_id');
    }

    public function coachHistory()
    {
        return $this->hasMany(CoachHistory::class, 'mt_id');
    }
}
