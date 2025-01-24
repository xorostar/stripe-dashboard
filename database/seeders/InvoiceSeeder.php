<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 users, each with 3-7 invoices
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                // Create array of statuses with desired distribution
                $statuses = array_merge(
                    array_fill(0, 3, ['paid' => true, 'status' => 'paid']),
                    array_fill(0, 3, ['paid' => false, 'status' => 'draft']),
                    array_fill(0, 3, ['paid' => false, 'status' => 'open']),
                    array_fill(0, 1, ['paid' => false, 'status' => 'past due'])
                );

                // Shuffle the statuses array
                shuffle($statuses);

                foreach ($statuses as $state) {
                    Invoice::factory()
                        ->state($state)
                        ->create([
                            'user_id' => $user->id
                        ]);
                }
            });
    }
}
