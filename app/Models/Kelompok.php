<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    protected $table = 'mskelompok';

    protected $primaryKey = 'kel_id';

    protected $fillable = [ 
        'kel_nama', 'kel_spk', 'kel_status', 
    ];
    
    // Relasi dengan Anggota (User)
    public function members()
    {
        return $this->hasMany(User::class, 'kel_id');
    }

    // relasi foreign key
    public function project()
    {
        return $this->belongsTo(Project::class, 'kel_spk', 'prj_no_spk');
    }
}
