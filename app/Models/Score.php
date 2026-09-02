<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Score extends Model
{
    use HasUuids;    

    protected $table= 'scores';
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
}
