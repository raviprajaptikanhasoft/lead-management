<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['information_id', 'user_id', 'status'];

    public function information()
    {
        return $this->belongsTo(Information::class);
    }

    public function notes()
    {
        return $this->hasMany(LeadNote::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
