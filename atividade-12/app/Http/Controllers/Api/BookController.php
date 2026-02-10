<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // GET /api/books
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    // GET /api/books/{id}
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book não encontrado'], 404);
        }

        return response()->json($book, 200);
    }

    // POST /api/books
    public function store(Request $request)
    {
        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    // PUT /api/books/{id}
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book não encontrado'], 404);
        }

        $book->update($request->all());

        return response()->json($book, 200);
    }

    // DELETE /api/books/{id}
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book não encontrado'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book removido com sucesso'], 200);
    }
}
