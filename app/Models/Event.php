<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    //どのカラムを保存できるか明示
    protected $fillable = [
        'title',
        'date',
        'location',
        'detail',
        'capacity',
        'category_id',
        'status_id',
        'organizer_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
