<?php

use App\Enums\BillStatusEnum;
use App\Models\Bill;
use App\Models\Transaction;
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
        Schema::create('bill_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Bill::class)->index();
            $table->foreignIdFor(Transaction::class)->nullable()->index();
            $table->date('due_date');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default(BillStatusEnum::PENDING->value);
            $table->date('paid_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_instances');
    }
};
