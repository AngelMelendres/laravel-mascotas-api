<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'email', 'fecha_nacimiento'];

    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }
}
