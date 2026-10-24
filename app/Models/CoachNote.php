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

    // created_at diisi DB (useCurrent), updated_at perlu di-manage Eloquent
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = ['coach_id', 'mt_id', 'coach_history_id', 'comments'];

    public function managementTrainee()
    {
        return $this->belongsTo(ManagementTrainee::class,'mt_id');
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function coachHistory()
    {
        return $this->belongsTo(CoachHistory::class);
    }
}