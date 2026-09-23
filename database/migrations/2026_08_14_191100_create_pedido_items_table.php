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
    Schema::create('pedido_items', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pedido_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('item_tipo');        // 'lanche' ou 'refrigerante'
        $table->unsignedBigInteger('item_id'); // id do lanche ou refrigerante de origem

        $table->string('item_nome');        // snapshot do nome no momento da compra
        $table->decimal('preco_unitario', 10, 2); // snapshot do preço
        $table->unsignedInteger('quantidade');
        $table->decimal('subtotal', 10, 2);

        $table->timestamps();
    });}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_items');
    }
};
