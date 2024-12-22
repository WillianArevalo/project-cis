<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class);
    }

    protected $fillable = [
        'name',
        'community_id'
    ];
}