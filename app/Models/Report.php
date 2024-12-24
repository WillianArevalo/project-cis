<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function images()
    {
        return $this->hasMany(ReportImages::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $fillable = [
        'project_id',
        'month',
        'theme',
        'number_participants',
        'description',
        'obstacles',
        'sent_by',
        'date'
    ];
}