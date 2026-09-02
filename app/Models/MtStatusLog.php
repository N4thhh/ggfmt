<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MtStatusLog extends Model
{
    use HasUuids;    

    protected $table= 'mt_status_logs';
    public $incrementing = false;
    protected $keyType = 'string';

    public function managementTrainee()
    {
        return $this->belongsTo(ManagementTrainee::class,'mt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
