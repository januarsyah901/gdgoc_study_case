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
        $books = Books::all();
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
        $book = new Books;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->published_at= $request->published_at;
        $book->save();
        return response()->json([
            'message' => 'Book created successfully',
            'book_id' => $book->id,
            'data' => $book
        ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Books::find($id);
        if(!empty($book)) {
            return response()->json($book);
        }
        else
        {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
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
        $book = Books::find($id);
        if(!empty($book)) {
            $book->title = is_null($request->title) ? $book->title : $request->title;
            $book->author = is_null($request->author) ? $book->author : $request->author;
            $book->published_at = is_null($request->published_at) ? $book->published_at : $request->published_at;
            $book->save();
            return response()->json([
                'message' => 'Book updated successfully',
                'data' => $book
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Books::where('id', $id)->exists()) {
            $book = Books::find($id);
            $book->delete();
            return response()->json([
                'message' => 'Book deleted successfully',
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }
    }
}
