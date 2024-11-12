<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quote;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'status'
    ];
    
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
