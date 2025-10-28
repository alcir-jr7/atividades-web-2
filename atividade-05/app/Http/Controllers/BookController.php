<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Listar todos os livros.
     */
    public function index()
    {
        // Carregar os livros com autores usando eager loading e paginação
        $books = Book::with('author')->paginate(20);

        return view('books.index', compact('books'));

    }

    /**
     * Mostrar detalhes de um livro específico.
     */
    public function show(Book $book)
    {
        // Carregando autor, editora e categoria do livro com eager loading
        $book->load(['author', 'publisher', 'category']);

        return view('books.show', compact('book'));

    }

    /**
     * Formulário de criação usando IDs.
     */
    public function createWithId()
    {
        return view('books.create-id');
    }

    /**
     * Armazenar livro criado via IDs.
     */
    public function storeWithId(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    /**
     * Formulário de criação usando select boxes.
     */
    public function createWithSelect()
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();

        return view('books.create-select', compact('authors', 'publishers', 'categories'));
    }

    /**
     * Armazenar livro criado via selects.
     */
    public function storeWithSelect(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    /**
     * Formulário de edição de livro.
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();

        return view('books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }
    

    /**
     * Atualizar livro existente.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
    }

    /**
     * Deletar livro.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso.');
    }
}
