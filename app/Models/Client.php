<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Client extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'prenom',
        'gender',
        'nom_pere',
        'prenom_pere',
        'nom_mere',
        'prenom_mere',
        'date_of_birth',
        'province',
        'commune',
        'colline',
        'residence_actuel',
        'nationalite',
        'religion',
        'telephone',
        'email',
        'cni',


        'has_passport',
        'passport',

        'has_cartejaune',
        'has_payerinscription',
        'has_permisconduire',

        'enfant',

        'marital_status',
        'francais',
        'anglais',
        'kiswahili',

        'niveau',

        'nom_avaliseur',
        'prenom_avaliseur',
        'cni_avaliseur',
        'telephone_avaliseur',
        'province_avaliseur',
        'commune_avaliseur',
        'colline_avaliseur',
        'lien_parente',

        'profile_image',
        
    ];
}
