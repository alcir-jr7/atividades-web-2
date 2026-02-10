<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;

class UserDebitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar usuários existentes (exceto admin/bibliotecário)
        $users = User::where('role', 'cliente')->take(5)->get();

        if ($users->isEmpty()) {
            $this->command->warn('Nenhum usuário cliente encontrado. Criando usuários...');
            
            // Criar usuários com débitos
            $users = collect([
                User::create([
                    'name' => 'João Silva',
                    'email' => 'joao@exemplo.com',
                    'password' => bcrypt('password'),
                    'role' => 'cliente',
                    'debit' => 0,
                ]),
                User::create([
                    'name' => 'Maria Santos',
                    'email' => 'maria@exemplo.com',
                    'password' => bcrypt('password'),
                    'role' => 'cliente',
                    'debit' => 0,
                ]),
                User::create([
                    'name' => 'Pedro Oliveira',
                    'email' => 'pedro@exemplo.com',
                    'password' => bcrypt('password'),
                    'role' => 'cliente',
                    'debit' => 0,
                ]),
                User::create([
                    'name' => 'Ana Costa',
                    'email' => 'ana@exemplo.com',
                    'password' => bcrypt('password'),
                    'role' => 'cliente',
                    'debit' => 0,
                ]),
                User::create([
                    'name' => 'Carlos Souza',
                    'email' => 'carlos@exemplo.com',
                    'password' => bcrypt('password'),
                    'role' => 'cliente',
                    'debit' => 0,
                ]),
            ]);
        }

        // Buscar alguns livros
        $books = Book::take(5)->get();

        if ($books->isEmpty()) {
            $this->command->error('Nenhum livro encontrado no banco. Por favor, cadastre livros antes de rodar esta seed.');
            return;
        }

        // Cenários de débitos
        $scenarios = [
            ['days_late' => 5, 'fine' => 2.50],   // 5 dias de atraso = R$ 2,50
            ['days_late' => 10, 'fine' => 5.00],  // 10 dias de atraso = R$ 5,00
            ['days_late' => 20, 'fine' => 10.00], // 20 dias de atraso = R$ 10,00
            ['days_late' => 30, 'fine' => 15.00], // 30 dias de atraso = R$ 15,00
            ['days_late' => 45, 'fine' => 22.50], // 45 dias de atraso = R$ 22,50
        ];

        foreach ($users as $index => $user) {
            if ($index >= count($scenarios)) {
                break;
            }

            $scenario = $scenarios[$index];
            $book = $books[$index];

            // Calcular data de empréstimo (prazo + dias de atraso)
            $daysAgo = 15 + $scenario['days_late'];
            $borrowedAt = Carbon::now()->subDays($daysAgo);
            $returnedAt = Carbon::now()->subDays($scenario['days_late'] - 2); // Devolveu há 2 dias

            // Criar empréstimo com atraso
            Borrowing::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrowed_at' => $borrowedAt,
                'returned_at' => $returnedAt,
            ]);

            // Adicionar débito ao usuário
            $user->update(['debit' => $scenario['fine']]);

            $this->command->info("✅ Usuário '{$user->name}' com débito de R$ " . number_format($scenario['fine'], 2, ',', '.') . " ({$scenario['days_late']} dias de atraso)");
        }

        $this->command->info('🎉 Seed de débitos executada com sucesso!');
    }
}