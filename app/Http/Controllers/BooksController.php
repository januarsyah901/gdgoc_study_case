<?php

namespace App\Http\Controllers;

use App\Models\Books; // Model untuk tabel 'books'
use Illuminate\Http\Request; // Untuk menangani HTTP request

class BooksController extends Controller
{
    /**
     * Menampilkan daftar semua buku yang ada.
     */
    public function index()
    {
        // Mengambil semua data buku dari tabel 'books'
        $books = Books::all();
        // Mengembalikan data buku dalam format JSON
        return response()->json($books);
    }

    /**
     * Menampilkan form untuk membuat buku baru (tidak digunakan dalam API RESTful).
     */
    public function create()
    {
        // Tidak digunakan dalam API berbasis JSON
    }

    /**
     * Menyimpan buku baru ke dalam database.
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
     * Menampilkan data dari buku tertentu berdasarkan ID.
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
     * Menampilkan form untuk mengedit buku tertentu (tidak digunakan dalam API RESTful).
     */
    public function edit(Books $books)
    {
        // Tidak digunakan dalam API berbasis JSON
    }

    /**
     * Memperbarui data buku tertentu berdasarkan ID.
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
     * Menghapus buku tertentu berdasarkan ID.
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
