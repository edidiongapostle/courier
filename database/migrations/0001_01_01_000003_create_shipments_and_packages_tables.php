<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users'); // requester, nullable
            $table->string('tracking_number')->unique();
            $table->string('status')->default('Pending'); // Overall shipment status
            $table->string('service_type');
            $table->decimal('total_weight', 8, 2);
            $table->decimal('price', 10, 2);
            $table->timestamp('eta')->nullable();
            $table->boolean('approved')->default(false); // Admin approval
            $table->timestamps();
        });

        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->onDelete('cascade');
            $table->string('barcode')->unique();
            $table->decimal('weight', 8, 2);
            $table->decimal('length', 8, 2);
            $table->decimal('width', 8, 2);
            $table->decimal('height', 8, 2);
            $table->string('status')->default('Pending');
            $table->timestamp('eta')->nullable();
            $table->timestamps();
        });

        Schema::create('package_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->string('status');
            $table->foreignId('updated_by')->constrained('users'); // admin who updated
            $table->timestamp('changed_at')->useCurrent();
            $table->text('note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_status_logs');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('shipments');
    }
}; 