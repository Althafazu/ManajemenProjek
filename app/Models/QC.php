<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QC extends Model
{
    
    // use HasFactory;

    protected $table = 'qcs'; 
    // protected $primaryKey = 'id'; 

   
    use HasFactory;

    protected $fillable = [
        'file', 
        'keterangan',
    ];
}
