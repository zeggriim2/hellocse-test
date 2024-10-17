<?php

namespace App\Models;

use App\Enums\StatusProfil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'image',
        'status'
    ];

    protected $casts = [
        'status' => StatusProfil::class,
    ];
}
