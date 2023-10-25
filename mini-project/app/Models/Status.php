<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
    protected $table = 'status';
    protected $primaryKey = 'id';
    protected $fillable = ['kondisi'];
    public $incrementing = false;
    use HasFactory;
}
