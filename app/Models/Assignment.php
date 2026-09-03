<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasUuids;    
    use HasFactory;

    protected $table= 'assignments';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function managementTrainee()
    {
        return $this->belongsTo(ManagementTrainee::class,'mt_id');
    }

    public function score()
    {
        return $this->hasMany(Score::class);
    }

    public function panelistAccess()
    {
        return $this->hasMany(PanelistAccess::class);
    }
}
