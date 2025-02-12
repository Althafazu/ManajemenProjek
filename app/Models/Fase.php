<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    protected $table = 'msfase';
    protected $primaryKey = 'apf_id';
    protected $fillable = ['nama_fase'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'fase_id', 'apf_id');
    }
}