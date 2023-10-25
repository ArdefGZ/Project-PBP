<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $timestamps = false;
    protected $table = 'rating_buku';
    protected $primaryKey = 'idbuku';
    protected $fillable = ['noktp', 'skor_rating', 'tgl_rating'];
    public $incrementing = false;
    use HasFactory;
}
