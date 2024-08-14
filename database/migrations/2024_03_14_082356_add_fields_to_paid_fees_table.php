<?php

use App\Models\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paid_fees', function (Blueprint $table) {
            $table->foreignIdFor(Student::class)->nullable()->after('id')->constrained();
            $table->decimal('discount_amount', 12, 2)->default(0)->after('payment_mode');
            $table->decimal('fine_amount', 12, 2)->default(0)->after('payment_mode');
            $table->decimal('due_amount', 12, 2)->default(0)->after('payment_mode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paid_fees', function (Blueprint $table) {
            $table->dropForeignIdFor(Student::class);
            $table->dropColumn(['student_id', 'due_amount', 'fine_amount', 'discount_amount']);
        });
    }
};
