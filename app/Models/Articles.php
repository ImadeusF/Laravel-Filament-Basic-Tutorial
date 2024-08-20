<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articles extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id', 'category_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //categories est le nom qui sera réutilisé avec le SELECT dans le fichier ArticlesResource.php
    //on spécifie que la clé étrangère est category_id pour ne pas avoir d'erreur
    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
