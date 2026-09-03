<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MtStatusLog extends Model
{
    use HasUuids;    
    use HasFactory;

    protected $table= 'mt_status_logs';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function managementTrainee()
    {
        return $this->belongsTo(ManagementTrainee::class,'mt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
