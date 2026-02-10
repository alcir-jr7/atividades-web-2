<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    /**
     * Campos que podem ser preenchidos via mass assignment
     * (store / update da API)
     */
    protected $fillable = [
        'title',
        'author_id',
        'category_id',
        'publisher_id',
        'published_year',
        'cover_image',
    ];

    /**
     * Tipagem automática (opcional, mas recomendado)
     */
    protected $casts = [
        'published_year' => 'integer',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    /**
     * Usuários que já pegaram o livro emprestado
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'borrowings')
            ->withPivot('id', 'borrowed_at', 'returned_at')
            ->withTimestamps();
    }
}
