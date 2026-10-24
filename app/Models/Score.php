<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Score extends Model
{
    use HasUuids;    
    use HasFactory;

    protected $table= 'scores';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'panelist_id',
        'assignment_id',
        'score',
        'comments',
        'submitted_at',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function panelist()
    {
        return $this->belongsTo(Panelist::class);
    }
}