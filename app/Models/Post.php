<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'published_at',
        'creator_id',
        'category_id',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
