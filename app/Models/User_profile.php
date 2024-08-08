<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_profile extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'first_name',
    'last_name',
    'profile_picture',
    'bio',
    'location',
    'phone_number',
    'website',
];
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function talentprofile()
  {
    return $this->belongsTo(Talent_profile::class, 'user_profile_id', 'id');
  }
  public function companyprofile()
  {
    return $this->hasOne(Company_profile::class);
  }
  public function individual()
  {
    return $this->hasOne(Individual::class);
  }
 
  public function getImgUrl()
  {
    if ($this->profile_picture) {
      return url('storage/' . $this->profile_picture);
    }
    return ;
  }
}
