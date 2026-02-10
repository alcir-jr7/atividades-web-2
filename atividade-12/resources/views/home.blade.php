@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                     <h4 class="mb-4">Bem-vindo! Escolha uma entidade para gerenciar:</h4>

                    <div class="row g-3">

                        <div class="col-md-4">
                            @can('viewAny', \App\Models\Book::class)
                                <a href="{{ route('books.index') }}" class="btn btn-primary w-100">
                                    Books
                                </a>
                            @endcan
                        </div>

                        <div class="col-md-4">
                            @can('viewAny', \App\Models\Publisher::class)
                                <a href="{{ route('publishers.index') }}" class="btn btn-secondary w-100">
                                    Publishers
                                </a>
                            @endcan
                        </div>

                        <div class="col-md-4">
                            @can('viewAny', \App\Models\Author::class)
                                <a href="{{ route('authors.index') }}" class="btn btn-info text-white w-100">
                                    Authors
                                </a>
                            @endcan
                        </div>

                        <div class="col-md-4">
                            @can('viewAny', \App\Models\Category::class)
                            <a href="{{ route('categories.index') }}" class="btn btn-warning w-100">
                                Categories
                            </a>
                            @endcan
                        </div>

                        <div class="col-md-4">
                            @can('viewAny', \App\Models\User::class)
                                <a href="{{ route('users.index') }}" class="btn btn-dark w-100">
                                    Users
                                </a>
                            @endcan
                        </div>
                        <div class="col-md-4">
                            @can('viewAny', \App\Models\User::class)
                                <a href="{{ route('users.debits') }}" class="btn btn-danger w-100">
                                    Gerenciar Débitos
                                </a>
                            @endcan
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
