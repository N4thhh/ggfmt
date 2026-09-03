<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MtProgram extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table= 'mt_programs';
    public $incrementing = false;
    protected $keyType = 'string';        
    public $timestamps = false;

    

    public function managementTrainees()
    {
        return $this->hasMany(ManagementTrainee::class);
    }
}
