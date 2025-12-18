<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $table = "informations";
    protected $fillable = ["text1", "text2", "text3", "text4", "text5", "text6", "text7", "text8", "text9", "user_id"];
    protected $hidden = [
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
