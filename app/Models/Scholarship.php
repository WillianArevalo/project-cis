<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    public function project()
    {
        return $this->belongsTo(Project::class, "project_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class, "community_id");
    }

    protected $fillable = [
        'name',
        'photo',
        'institution',
        'academic_level',
        'career',
        'study_level',
        'community_id',
        'project_id',
        'user_id',
        'type'
    ];
}