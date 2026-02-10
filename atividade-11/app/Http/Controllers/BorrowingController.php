<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // Verifica se o usuário possui débitos pendentes
        if ($user->hasDebit()) {
            return redirect()
                ->route('books.show', $book)
                ->with('error', 'Este usuário possui débitos pendentes de R$ ' . number_format($user->debit, 2, ',', '.') . ' e não pode realizar novos empréstimos.');
        }

        // Verifica se o livro já está emprestado
        $livroEmprestado = Borrowing::where('book_id', $book->id)
            ->whereNull('returned_at')
            ->exists();

        if ($livroEmprestado) {
            return redirect()
                ->route('books.show', $book)
                ->with('error', 'Este livro já está emprestado e ainda não foi devolvido.');
        }

        // Verifica quantos livros o usuário já tem emprestados
        $emprestimosUsuario = Borrowing::where('user_id', $request->user_id)
            ->whereNull('returned_at')
            ->count();

        if ($emprestimosUsuario >= 5) {
            return redirect()
                ->route('books.show', $book)
                ->with('error', 'Este usuário já possui o limite máximo de 5 livros emprestados.');
        }

        // Registra o empréstimo
        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'returned_at' => null,
        ]);

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Empréstimo registrado com sucesso.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        // Define a data de devolução
        $returnedAt = now();
        
        // Calcula os dias de atraso
        $borrowedAt = Carbon::parse($borrowing->borrowed_at);
        $daysLate = $returnedAt->diffInDays($borrowedAt) - 15; // 15 dias é o prazo

        // Se houver atraso, calcula a multa
        if ($daysLate > 0) {
            $fineAmount = $daysLate * 0.50; // R$ 0,50 por dia
            $borrowing->user->addDebit($fineAmount);

            $borrowing->update([
                'returned_at' => $returnedAt,
            ]);

            return redirect()
                ->route('books.show', $borrowing->book_id)
                ->with('warning', "Devolução registrada com {$daysLate} dia(s) de atraso. Multa de R$ " . number_format($fineAmount, 2, ',', '.') . ' adicionada ao débito do usuário.');
        }

        // Devolução sem atraso
        $borrowing->update([
            'returned_at' => $returnedAt,
        ]);

        return redirect()
            ->route('books.show', $borrowing->book_id)
            ->with('success', 'Devolução registrada com sucesso. Sem atraso.');
    }

    public function userBorrowings(User $user)
    {
        $borrowings = $user->books()->withPivot('borrowed_at', 'returned_at')->get();

        return view('users.borrowings', compact('user', 'borrowings'));
    }


    /**
     * Exibe usuários com débitos (apenas para bibliotecários)
     */
    public function usersWithDebit()
    {
        $this->authorize('viewAny', User::class);

        $usersWithDebit = User::where('debit', '>', 0)->paginate(10);

        return view('users.debits', compact('usersWithDebit')); // ← Aqui mudou
    }

    /**
     * Zera o débito de um usuário (apenas para bibliotecários)
     */
    public function clearDebit(User $user)
    {
        $this->authorize('update', $user);

        $debitAmount = $user->debit;
        $user->clearDebit();

        return redirect()
            ->route('users.debits')
            ->with('success', "Débito de R$ " . number_format($debitAmount, 2, ',', '.') . " do usuário {$user->name} foi zerado com sucesso.");
    }
}