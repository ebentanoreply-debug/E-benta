<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->cascadeOnDelete();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->decimal('fee_amount', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2);
            $table->string('status', 30)->default('pending');
            $table->string('paymongo_checkout_session_id')->nullable()->unique();
            $table->string('paymongo_payment_intent_id')->nullable()->index();
            $table->string('paymongo_payment_id')->nullable()->index();
            $table->string('checkout_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();

            $table->index(['offer_id', 'status']);
        });

        Schema::create('seller_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->decimal('available_balance', 10, 2)->default(0);
            $table->decimal('pending_balance', 10, 2)->default(0);
            $table->decimal('paid_out_balance', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_wallet_id')->constrained('seller_wallets')->cascadeOnDelete();
            $table->foreignId('offer_id')->nullable()->constrained('offers')->nullOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->foreignId('payout_request_id')->nullable();
            $table->string('type', 40);
            $table->decimal('amount', 10, 2);
            $table->decimal('balance_after', 10, 2);
            $table->string('status', 30)->default('posted');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->index(['type', 'status']);
        });

        Schema::create('payout_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_wallet_id')->constrained('seller_wallets')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('status', 30)->default('pending');
            $table->string('destination_type', 30)->default('gcash');
            $table->string('destination_label')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();

            $table->index(['seller_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payout_requests');
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('seller_wallets');
        Schema::dropIfExists('payments');
    }
};
