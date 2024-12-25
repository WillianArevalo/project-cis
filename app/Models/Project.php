<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    protected $fillable = [
        'name',
        'slug',
        'community_id',
        'accept',
        'document',
        'sent_by'
    ];
}