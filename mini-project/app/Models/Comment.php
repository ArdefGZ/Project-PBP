<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anggota;
use App\Models\Book;
use App\Models\Rating;

class Comment extends Model
{
    public $timestamps = false;
    protected $table = 'komentar_buku';
    protected $primaryKey = 'idkomentar';
    protected $fillable = ['idbuku', 'noktp', 'komentar'];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'noktp', 'noktp');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'idbuku', 'idbuku');
    }

    public function rate()
    {
        return $this->belongsTo(Rating::class, 'idbuku', 'idbuku');
    }
    use HasFactory;
}
