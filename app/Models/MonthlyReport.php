<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected $fillable = [
        'project_id',
        'month',
        'theme',
        'number_paricipants',
        'description',
        'obstacles',
        'sent_by',
        'date'
    ];
}