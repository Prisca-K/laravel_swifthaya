<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    use HasFactory;

    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function project()
    {
      return $this->hasMany(Project::class);
    }
    public function application()
    {
      return $this->hasMany(Application::class);
    }
    
}
