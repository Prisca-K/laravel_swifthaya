<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  use HasFactory;
  protected $fillable = [
    'poster_id',
    'title',
    'description',
    'required_skills',
    'budget',
    'duration',
    'deadline_date',
  ];

  protected $casts = [
    'required_skills' => 'array',
    'posted_at' => 'datetime',
    'deadline_date' => 'datetime',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, "poster_id");
  }
  public function application()
  {
    return $this->hasMany(Application::class, "project_id");
  }
}
