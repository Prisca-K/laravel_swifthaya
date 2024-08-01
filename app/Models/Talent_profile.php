<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent_profile extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_profile_id', 'skills', 'experience', 'education', 'portfolio',
  ];

  protected $casts = [
    'skills' => 'array',
    'experience' => 'array',
    'education' => 'array',
    'portfolio' => 'array',
  ];

  public function userProfile()
  {
    return $this->belongsTo(User_profile::class);
  }
}
