<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PanelistAccess extends Model
{
    use HasUuids;    
    use HasFactory;

    protected $table= 'panelist_access';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'panelist_id',
        'assignment_id',
        'assigned_by',
        'assigned_at',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function panelist()
    {
        return $this->belongsTo(Panelist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}