<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CoachHistory extends Model
{
    use HasUuids;

    protected $table= 'coach_histories';
    public $incrementing = false;
    protected $keyType = 'string';

    public function managementTrainee()
    {
        return $this->belongsTo(ManagementTrainee::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
