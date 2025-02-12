<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktualPlan extends Model
{
    protected $table = 'msaktualplan';
    protected $primaryKey = 'ap_id';
    protected $fillable = ['prj_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'prj_id', 'prj_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'ap_id', 'ap_id');
    }
}