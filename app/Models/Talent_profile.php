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
    'skills' => 'array', // Cast skills as an array
    'experience' => 'array', // Cast experience as an array
    'education' => 'array', // Cast education as an array
    'portfolio' => 'array',
  ];

  public function userprofile()
  {
    return $this->belongsTo(User_profile::class, 'user_profile_id', 'id');
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }

}
