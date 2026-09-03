<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoachHistory extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table= 'coach_histories';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function managementTrainee()
    {
        return $this->belongsTo(ManagementTrainee::class,'mt_id');
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'assigned_by');
    }
}
