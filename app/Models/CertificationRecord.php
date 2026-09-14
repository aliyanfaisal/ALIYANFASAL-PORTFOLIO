<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationRecord extends Model
{
    protected $fillable = ['name', 'issuer', 'year', 'sort_order'];
}
