<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Utilisateur extends Model
{
    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'email',
        'password',
        'telephone'
    ];

    protected $hidden = [
        'password'
    ];

    // relations
    public function passager()
    {
        return $this->hasOne(Passager::class);
    }

    public function conducteur()
    {
        return $this->hasOne(Conducteur::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function verifierMotDePasse($password)
    {
        return Hash::check($password, $this->password);
    }
}