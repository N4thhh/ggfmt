<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PanelistAccess extends Model
{
    use HasUuids;    

    protected $table= 'panelist_access';
    public $incrementing = false;
    protected $keyType = 'string';

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
