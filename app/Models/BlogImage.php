<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'blog_id',
    'image_path',
    'alt_text',
    'caption',
    'sort_order',
    'is_primary'
  ];

  protected $casts = [
    'is_primary' => 'boolean',
    'sort_order' => 'integer'
  ];

  /**
   * Get the blog that owns the image.
   */
  public function blog()
  {
    return $this->belongsTo(Blog::class);
  }
}
