<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_profile extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_profile_id',
    'company_name',
    'industry',
    'company_size',
    'founded_year',
  ];

  public function userprofile()
  {
    return $this->belongsTo(User_profile::class, 'user_profile_id', 'id');
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function swifthayajob()
  {
    return $this->hasMany(SwifthayaJob::class, 'company_id');
  }
}
