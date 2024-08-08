<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Swifthayajob extends Model
{
  use HasFactory;
  protected $fillable = [
    'company_id',
    'title',
    'description',
    'required_skills',
    'location',
    'salary_range',
    'job_type',
    'posted_at',
    'deadline_date',
  ];

  protected $casts = [
    'required_skills' => 'array',
    'posted_at' => 'datetime',
    'deadline_date' => 'datetime',
  ];

  public function companyprofile()
  {
    return $this->belongsTo(Company_profile::class);
  }
}
