<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Anggota;
use App\Models\Comment;
use Illuminate\Support\Facades\Http;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    function index()
    {
        $books = Book::all();
        $comments = Comment::all();
        return view("welcome")->with("books", $books)->with("comments", $comments);
    }

    function details(Request $request, $idbuku)
    {
        $book = Book::find($idbuku);
        $comment = Comment::find($idbuku);
        $categories = Kategori::all();
        return view("sesi/details")->with("book", $book)->with("categories", $categories)->with("comment", $comment);
    }

    function create()
    {
        $categories = Kategori::all();
        return view("sesi/create")->with("categories", $categories);
    }

    function store(Request $request)
    {
        $book = new Book;
        $book->isbn = $request->input('isbn');
        $book->judul = $request->input('judul');
        $book->idkategori = $request->input('idkategori');
        $book->penerbit = $request->input('penerbit');
        $book->pengarang = $request->input('pengarang');
        $book->kota_terbit = $request->input('kota_terbit');
        $book->editor = $request->input('editor');
        $book->stok = $request->input('stok');
        $book->stok_tersedia = $request->input('stok');
        $book->tgl_insert = now();
        $book->tgl_update = now();

        // Handle the file upload here
        if ($request->hasFile('file') && $request->file('file') instanceof UploadedFile) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/assets/images/books', $filename);
            $book->file_gambar =  $request->input('file'); // Save the path to the file
        } else {
            $book->file_gambar = "https://i.imgur.com/2ZcX2Gy.png";
        }

        $book->save();

        return redirect('/dashboard');
    }



    function edit(Request $request, $idbuku)
    {
        $book = Book::find($idbuku);
        if (!$book) {
            // Handle the case where the book is not found
            // You can customize this part based on your application's logic.
            return redirect('/dashboard')->with('error', 'Book not found');
        }
        $book->isbn = $request->input('isbn');
        $book->judul = $request->input('judul');
        $book->idkategori = $request->input('idkategori');
        $book->penerbit = $request->input('penerbit');
        $book->kota_terbit = $request->input('kota_terbit');
        $book->editor = $request->input('editor');

        $book->save();

        return redirect('/dashboard');
    }

    function verification()
    {
        $members = Anggota::all();
        return view('sesi/verification')->with("members", $members);
    }

    function member_details(Request $request, $noktp)
    {
        $member = Anggota::find($noktp);
        return view('sesi/member_details')->with("member", $member);
    }

    function changeStatus($noktp)
    {
        $member = Anggota::find($noktp);
        $member->idstatus = 1;
        $member->save();
        return redirect('/dashboard');
    }

    function history()
    {
        $books = Book::all();
        $lends = Peminjaman::all();
        return view('sesi/history')->with("books", $books)->with("lends", $lends);
    }

    function lend()
    {
        $members = Anggota::all();
        $lends = Peminjaman::all();
        $books = Book::all();
        return view('sesi/lend')->with("members", $members)->with("lends", $lends)->with("books", $books);
    }

    function return()
    {
        $lends = Peminjaman::all();
        return view('sesi/return')->with("lends", $lends);
    }

    function confirm($idtransaksi)
    {
        $lend = Peminjaman::find($idtransaksi);
        $lend->transaction->tgl_kembali = now();
        return redirect('/dashboard');
    }

    function add(Request $request)
    {
        $lend = new Peminjaman;
        $return = new Transaction;
        $lend->noktp = $request->input('nama');
        $lend->idbuku = $request->input('judul');
        $lend->tgl_pinjam = date('Y-m-d H:i:s');
        $return->idbuku = $request->input('judul');
        $lend->save();
        return redirect('/dashboard');
    }

    function delete(Request $request, $idbuku)
    {
        $book = Book::find($idbuku);
        $book->delete();
        return redirect('/dashboard');
    }
}

// // Validate the input data here if needed
        // // Define validation rules
        // $rules = [
        //     'isbn' => 'required',
        //     'judul' => 'required',
        //     'kategori' => 'required',
        //     'pengarang' => 'required',
        //     'kota_terbit' => 'required',
        //     'editor' => 'required',
        //     'stok' => 'required|numeric',
        //     'file' => 'required|file|mimes:jpeg,png,pdf', // Example validation for a file upload
        // ];

        // // Define custom error messages
        // $messages = [
        //     'required' => 'The :attribute field is required.',
        //     'numeric' => 'The :attribute must be a number.',
        //     'file' => 'The :attribute must be a file.',
        //     'mimes' => 'The :attribute must be a file of type: :values',
        // ];

        // // Validate the input data
        // $validator = Validator::make($request->all(), $rules, $messages);

        // // Check if validation fails
        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }
        // $book = new Book;
        // $book->isbn = $request->input('isbn');
        // $book->judul = $request->input('judul');
        // $book->idkategori = $request->input('kategori');
        // $book->pengarang = $request->input('pengarang');
        // $book->kota_terbit = $request->input('kota_terbit');
        // $book->editor = $request->input('editor');
        // $book->stok = $request->input('stok');
        // $book->stok_tersedia = $request->input('stok');
        // $book->tgl_insert = date('Y-m-d H:i:s');
        // $book->tgl_update = date('Y-m-d H:i:s');
        // $book->file_gambar = $request->input('file_gambar');

        // // Handle the file upload here if necessary
        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $filename = $file->getClientOriginalName(); // You can customize the filename as needed
        //     $file->storeAs('/assets/images/books', $filename); 
        //     $book->file_path = '/assets/images/books/' . $filename; // Save the file path in the database
        // }

        // if ($book->save()) {
        //     Log::info('Book saved successfully.');
        // } else {
        //     Log::error('Failed to save the book.');
        // }

        // // Redirect to a success page or wherever you need
        // return redirect()->back()->with('success', 'Book added successfully.');