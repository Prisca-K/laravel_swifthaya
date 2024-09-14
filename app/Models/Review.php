<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  use HasFactory;
  protected $fillable = [
    'reviewer_id',
    'reviewee_id',
    // 'job_id',
    // 'project_id',
    'rating',
    'review'
  ];
  public function reviewer()
  {
    return $this->belongsTo(User::class, 'reviewer_id');
  }

  public function reviewee()
  {
    return $this->belongsTo(User::class, 'reviewee_id');
  }

  public function swifthayajob()
  {
    return $this->belongsTo(Swifthayajob::class);
  }

  public function project()
  {
    return $this->belongsTo(Project::class);
  }
}
