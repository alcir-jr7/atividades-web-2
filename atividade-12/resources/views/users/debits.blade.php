@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h1>Usuários com Débitos Pendentes</h1>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
            Voltar para Usuários
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($usersWithDebit->isEmpty())
        <div class="alert alert-info">
            Nenhum usuário com débitos pendentes no momento.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Débito Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usersWithDebit as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-danger">
                                R$ {{ number_format($user->debit, 2, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('users.clear-debit', $user) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Tem certeza que deseja zerar o débito de R$ {{ number_format($user->debit, 2, ',', '.') }} do usuário {{ $user->name }}?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">
                                    Zerar Débito
                                </button>
                            </form>

                            <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> Visualizar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $usersWithDebit->links() }}
        </div>
    @endif
</div>
@endsection