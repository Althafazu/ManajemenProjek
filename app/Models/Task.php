<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'mstask';
    protected $primaryKey = 'tsk_id';
    protected $fillable = [
        'ap_id',
        'apf_id',
        'pic',
        'progress',
        'plan_start',
        'plan_end',
        'actual_start',
        'actual_end',
        'status'
    ];
    
    public function aktualPlan()
    {
        return $this->belongsTo(AktualPlan::class, 'ap_id', 'ap_id');
    }

    public function fase()
    {
        return $this->belongsTo(Fase::class, 'apf_id', 'apf_id');
    }

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic', 'usr_id');
    }
}
