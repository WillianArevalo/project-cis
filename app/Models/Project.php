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

    protected $fillable = [
        'name',
        'slug',
        'community_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($project) {
            $project->slug = Str::slug($project->name);
        });
    }
}