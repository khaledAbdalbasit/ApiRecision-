<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'text', 'phone', 'status', 'user_id', 'domain_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function domain(){
        return $this->belongsTo(Domain::class);
    }
}
