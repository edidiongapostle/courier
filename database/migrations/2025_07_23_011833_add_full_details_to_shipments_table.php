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
        Schema::table('shipments', function (Blueprint $table) {
            // Sender details
            $table->string('sender_name')->nullable();
            $table->string('sender_phone')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('sender_country')->nullable();
            $table->string('sender_street')->nullable();
            $table->string('sender_city')->nullable();
            $table->string('sender_state')->nullable();
            $table->string('sender_postal_code')->nullable();
            // Receiver details
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('receiver_country')->nullable();
            $table->string('receiver_street')->nullable();
            $table->string('receiver_city')->nullable();
            $table->string('receiver_state')->nullable();
            $table->string('receiver_postal_code')->nullable();
            // Shipment type
            $table->string('shipment_type')->nullable();
            $table->string('document_category')->nullable();
            // Package details
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->text('contents_description')->nullable();
            $table->decimal('declared_value', 12, 2)->nullable();
            $table->string('commodity_code')->nullable();
            // Insurance
            $table->boolean('insurance_enabled')->nullable();
            $table->decimal('insurance_value', 12, 2)->nullable();
            $table->decimal('insurance_cost', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn([
                'sender_name','sender_phone','sender_email','sender_country','sender_street','sender_city','sender_state','sender_postal_code',
                'receiver_name','receiver_phone','receiver_email','receiver_country','receiver_street','receiver_city','receiver_state','receiver_postal_code',
                'shipment_type','document_category','length','width','height','contents_description','declared_value','commodity_code',
                'insurance_enabled','insurance_value','insurance_cost',
            ]);
        });
    }
};
