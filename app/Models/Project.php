<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $primaryKey = 'prj_id';

    protected $fillable = [
        'prj_no_spk',
        'prj_nama',
        'prj_jenis',
        'prj_status',
        'prj_start_date',
        'prj_deadline',
    ];

    /**
     * Mutator for prj_status
     * Ensure only allowed values are set.
     */
    public function setPrjStatusAttribute($value)
    {
        $allowedStatus = ['Sedang Berlangsung', 'Selesai', 'Batal'];
        $this->attributes['prj_status'] = in_array($value, $allowedStatus) ? $value : 'Sedang Berlangsung';
    }

    /**
     * Mutator for prj_jenis
     * Ensure only allowed values are set.
     */
    public function setPrjJenisAttribute($value)
    {
        $allowedJenis = ['Internal', 'Eksternal'];
        $this->attributes['prj_jenis'] = in_array($value, $allowedJenis) ? $value : 'Internal';
    }


    public function kelompoks() 
    {
        return $this->hasMany(Kelompok::class, 'kel_id', 'kel_id');    
    }
    // public function gamteks()
    // {
    //     return $this->hasMany(Gamtek::class, 'prj_id', 'prj_id');
    // }
}