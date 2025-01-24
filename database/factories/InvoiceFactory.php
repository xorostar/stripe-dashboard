<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 10, 1000);
        $tax = $this->faker->randomFloat(2, 0, $subtotal * 0.2);
        $total = $subtotal + $tax;

        return [
            'id' => 'inv_' . Str::uuid(),
            'account_country' => $this->faker->countryCode(),
            'account_name' => $this->faker->company(),
            'amount_due' => $total,
            'amount_paid' => $this->faker->randomElement([$total, 0]),
            'auto_advance' => $this->faker->boolean(),
            'billing_reason' => $this->faker->randomElement(['subscription', 'manual', 'upcoming']),
            'collection_method' => $this->faker->randomElement(['charge_automatically', 'send_invoice']),
            'currency' => 'usd',
            'user_id' => User::factory(),
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'number' => $this->faker->bothify('INV-####-####'),
            'paid' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(['draft', 'open', 'paid', 'void', 'uncollectible']),
            'subtotal' => $subtotal,
            'subtotal_excluding_tax' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'total_excluding_tax' => $subtotal,
            'metadata' => ['key' => 'value'],
            'recurring_payment' => $this->faker->boolean(),
        ];
    }

    public function paid(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'paid' => true,
                'amount_paid' => $attributes['total'],
                'status' => 'paid',
            ];
        });
    }

    public function unpaid(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'paid' => false,
                'amount_paid' => 0,
                'status' => 'open',
            ];
        });
    }
}
