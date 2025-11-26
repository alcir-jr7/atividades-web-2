@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card mb-4">
        <div class="card-header">Informações do Livro</div>
        <div class="card-body d-flex align-items-start gap-4">

                @if ($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Capa do livro" style="max-height: 150px; border-radius: 4px;">
                @else
                    <p>Sem capa cadastrada.</p>
                @endif

            <div>
                <h3>{{ $book->title }}</h3>

                <p><strong>ID:</strong> {{ $book->id }}</p>
                <p><strong>Autor:</strong> {{ $book->author->name }}</p>
                <p><strong>Editora:</strong> {{ $book->publisher->name }}</p>
                <p><strong>Categoria:</strong> {{ $book->category->name }}</p>

                @if($book->published_year)
                    <p><strong>Ano de Publicação:</strong> {{ $book->published_year }}</p>
                @endif

            </div>

        </div>
    </div>

    <!-- Formulário para Empréstimos -->
    <div class="card mb-4">
        <div class="card-header">Registrar Empréstimo</div>
        <div class="card-body">
            <form action="{{ route('books.borrow', $book) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="user_id" class="form-label">Usuário</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="" selected>Selecione um usuário</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Registrar Empréstimo</button>
            </form>
        </div>
    </div>

    <!-- Histórico de Empréstimos -->
    <div class="card">
        <div class="card-header">Histórico de Empréstimos</div>
        <div class="card-body">
            @if($book->users->isEmpty())
                <p>Nenhum empréstimo registrado.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Data de Empréstimo</th>
                            <th>Data de Devolução</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($book->users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td>{{ $user->pivot->borrowed_at }}</td>
                            <td>{{ $user->pivot->returned_at ?? 'Em Aberto' }}</td>
                            <td>
                                @if(is_null($user->pivot->returned_at))
                                    <form action="{{ route('borrowings.return', $user->pivot->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-warning btn-sm">Devolver</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>
@endsection
