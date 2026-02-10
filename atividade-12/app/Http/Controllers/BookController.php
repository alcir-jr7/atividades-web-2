<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Listar todos os livros.
     */
    public function index()
    {
        $this->authorize('viewAny', Book::class);

        // Carregar os livros com autores usando eager loading e paginação
        $books = Book::with('author')->paginate(20);

        return view('books.index', compact('books'));

    }

    /**
     * Mostrar detalhes de um livro específico.
     */
    public function show(Book $book)
    {
        $this->authorize('view', $book);

        // Carregando autor, editora e categoria do livro com eager loading
        $book->load(['author', 'publisher', 'category']);

        // Carregar todos os usuários para o formulário de empréstimo
        $users = User::all();

        return view('books.show', compact('book','users'));

    }

    /**
     * Formulário de criação usando IDs.
     */
    public function createWithId()
    {
        $this->authorize('create', Book::class);

        return view('books.create-id');
    }

    /**
     * Armazenar livro criado via IDs.
     */
    public function storeWithId(Request $request)
    {
        $this->authorize('create', Book::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'title',
            'author_id',
            'publisher_id',
            'category_id',
            'published_year',
        ]);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');

            $path = Storage::disk('public')->putFile('covers', $file);

            $data['cover_image'] = $path;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    /**
     * Formulário de criação usando select boxes.
     */
    public function createWithSelect()
    {
        $this->authorize('create', Book::class);

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
        $this->authorize('create', Book::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'title',
            'author_id',
            'publisher_id',
            'category_id',
            'published_year',
        ]);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');

            $path = Storage::disk('public')->putFile('covers', $file);

            $data['cover_image'] = $path;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    /**
     * Formulário de edição de livro.
     */
    public function edit(Book $book)
    {
        $this->authorize('update', $book);

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
        $this->authorize('update', $book);

        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'title',
            'author_id',
            'publisher_id',
            'category_id',
            'published_year',
        ]);

        if ($request->hasFile('cover_image')) {

            // Apagar imagem antiga (se existir)
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }

            // Salvar nova imagem
            $file = $request->file('cover_image');
            $path = Storage::disk('public')->putFile('covers', $file);
            $data['cover_image'] = $path;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
    }

    /**
     * Deletar livro.
     */
    public function destroy(Book $book)
    {   
        $this->authorize('delete', $book);

        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso.');
    }
}
