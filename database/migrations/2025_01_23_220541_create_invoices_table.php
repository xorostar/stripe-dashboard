<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->string('account_country')->nullable();
            $table->string('account_name')->nullable();
            $table->decimal('amount_due', 10, 2)->default(0);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->boolean('auto_advance')->default(false);
            $table->string('billing_reason')->nullable();
            $table->string('collection_method')->nullable();
            $table->string('currency')->default('usd');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('due_date')->nullable();
            $table->string('number')->nullable();
            $table->boolean('paid')->default(false);
            $table->string('status')->default('draft');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('subtotal_excluding_tax', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('total_excluding_tax', 10, 2)->default(0);
            $table->json('metadata')->nullable();
            $table->boolean('recurring_payment')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
