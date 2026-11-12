<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['reviewer_name', 'reviewer_title', 'review_text', 'rating', 'is_published'];
    protected $casts = ['is_published' => 'boolean'];
}
