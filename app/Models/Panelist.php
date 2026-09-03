<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panelist extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table= 'panelists';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function panelistAccess()
    {
        return $this->hasMany(PanelistAccess::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
