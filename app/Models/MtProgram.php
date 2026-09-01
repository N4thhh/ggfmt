<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MtProgram extends Model
{
    use HasUuids;

    protected $table= 'mt_programs';
    public $incrementing = false;
    protected $keyType = 'string';

    public function managementTrainees()
    {
        return $this->hasMany(ManagementTrainee::class);
    }
}
