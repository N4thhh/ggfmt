<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoachNote extends Model
{
    use HasUuids;    
    use HasFactory;

    protected $table= 'coach_notes';
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
}
