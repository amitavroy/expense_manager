<?php

use App\Models\Biller;
use App\Models\User;
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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->index();
            $table->foreignIdFor(Biller::class)->index();
            $table->decimal('default_amount', 10, 2);
            $table->string('frequency');
            $table->unsignedTinyInteger('day_of_month')->nullable();
            $table->unsignedTinyInteger('interval_days')->nullable();
            $table->date('next_payment_date');
            $table->boolean('is_active')->default(true);
            $table->boolean('auto_generate_bill')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
