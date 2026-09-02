<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CoachNote extends Model
{
    use HasUuids;    

    protected $table= 'coach_notes';
    public $incrementing = false;
    protected $keyType = 'string';

    public function managementTrainee()
    {
        return $this->belongsTo(ManagementTrainee::class,'mt_id');
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
