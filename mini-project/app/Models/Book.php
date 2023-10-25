<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Comment;

class Book extends Model
{
    public $timestamps = false;
    protected $table = 'buku';
    protected $primaryKey = 'idbuku';
    protected $fillable = ['isbn', 'judul', 'idkategori', 'pengarang', 'penerbit', 'kota_terbit', 'editor', 'file_gambar', 'tgl_insert, tgl_update, stok, stok, stok_tersedia'];
    public $incrementing = false;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori', 'idkategori');
    }

    public function comment(){
        return $this->belongsTo(Comment::class, 'idbuku', 'idbuku');
    }


    use HasFactory;
}
