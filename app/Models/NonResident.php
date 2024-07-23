<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonResident extends Model
{
    use HasFactory;

    protected $table = 'non_residents';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'phone_num', 'plate_num', 'entry_time', 'status'];
}
