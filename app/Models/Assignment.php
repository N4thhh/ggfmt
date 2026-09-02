<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Assignment extends Model
{
    use HasUuids;    

    protected $table= 'assignments';
    public $incrementing = false;
    protected $keyType = 'string';

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
