<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Panelist extends Model
{
    use HasUuids;

    protected $table= 'panelists';
    public $incrementing = false;
    protected $keyType = 'string';
    
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
