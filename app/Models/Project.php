<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_id', 
        'project_title', 
        'description', 
        'date'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
}
