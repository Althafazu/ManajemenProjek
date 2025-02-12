<?php
// app/Models/MsUser.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'msuser';
    protected $primaryKey = 'usr_id';
    
    protected $fillable = [
        'usr_name',
        'usr_password',
        'kel_id',
        'rol_id',
        'usr_status'
    ];

    public function getAuthPassword()
    {
        return $this->usr_password;
    }

    public function getAuthIdentifierName()
    {
        return 'usr_name';
    }

    protected $hidden = [
        'usr_password',
        'remember_token',
    ];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kel_id', 'kel_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id', 'rol_id');
    }

    public function hasRole($roleId)
    {
        return $this->rol_id === $roleId;
    }
}