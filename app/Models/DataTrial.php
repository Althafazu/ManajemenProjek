<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTrial extends Model
{
    use HasFactory;
    protected $table = 'datatrials'; 


    protected $fillable = [
        'file', 
        'keterangan',
    ];
}
