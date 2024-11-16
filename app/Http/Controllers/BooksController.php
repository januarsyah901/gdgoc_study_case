<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data buku dari tabel 'books'
        $books = Books::all();

        // Mengembalikan data buku dalam format JSON
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Membuat instance baru dari model Books
        $book = new Books;

        // Mengisi properti buku dari data request
        $book->title = $request->title;
        $book->author = $request->author;
        $book->published_at = $request->published_at;

        // Menyimpan buku ke database
        $book->save();

        // Mengembalikan respon JSON setelah buku berhasil dibuat
        return response()->json([
            'message' => 'Book created successfully', // Pesan sukses
            'book_id' => $book->id, // ID buku yang baru dibuat
            'data' => $book // Data buku yang baru dibuat
        ], 201); // Status HTTP 201 (Created)
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mencari buku berdasarkan ID
        $book = Books::find($id);

        if (!empty($book)) {
            // Jika buku ditemukan, kembalikan data buku
            return response()->json($book);
        } else {
            // Jika buku tidak ditemukan, kembalikan pesan error
            return response()->json([
                'message' => 'Book not found',
            ], 404); // Status HTTP 404 (Not Found)
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Books $books)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Mencari buku berdasarkan ID
        $book = Books::find($id);

        if (!empty($book)) {
            // Memperbarui data buku hanya jika nilai baru diberikan
            $book->title = is_null($request->title) ? $book->title : $request->title;
            $book->author = is_null($request->author) ? $book->author : $request->author;
            $book->published_at = is_null($request->published_at) ? $book->published_at : $request->published_at;

            // Menyimpan perubahan ke database
            $book->save();

            // Mengembalikan respon JSON setelah buku berhasil diperbarui
            return response()->json([
                'message' => 'Book updated successfully', // Pesan sukses
                'data' => $book // Data buku yang telah diperbarui
            ], 200); // Status HTTP 200 (OK)
        } else {
            // Jika buku tidak ditemukan, kembalikan pesan error
            return response()->json([
                'message' => 'Book not found',
            ], 404); // Status HTTP 404 (Not Found)
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Memeriksa apakah buku dengan ID tersebut ada di database
        if (Books::where('id', $id)->exists()) {
            // Mengambil buku berdasarkan ID
            $book = Books::find($id);

            // Menghapus buku dari database
            $book->delete();

            // Mengembalikan pesan sukses
            return response()->json([
                'message' => 'Book deleted successfully',
            ], 200); // Status HTTP 200 (OK)
        } else {
            // Jika buku tidak ditemukan, kembalikan pesan error
            return response()->json([
                'message' => 'Book not found',
            ], 404); // Status HTTP 404 (Not Found)
        }
    }
}
