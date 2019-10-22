<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductVariationStockView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('
            CREATE VIEW product_variation_stock_view AS
            SELECT product_variations.id AS product_variation_id,
                product_variations.product_id AS product_id,
                (
                   COALESCE(stocks.quantity, 0) -
                   COALESCE(order_product_variation.quantity, 0)
               ) AS stock,
               CASE WHEN (
                   COALESCE(stocks.quantity, 0) -
                   COALESCE(order_product_variation.quantity, 0)
               ) > 0
                   THEN TRUE
                   ELSE FALSE
               END AS in_stock
            FROM product_variations
            LEFT JOIN (
                SELECT stocks.product_variation_id AS product_variation_id,
                    SUM(stocks.quantity) AS quantity
                FROM stocks
                GROUP BY stocks.product_variation_id
            ) AS stocks ON stocks.product_variation_id = product_variations.id
            LEFT JOIN (
                SELECT order_product_variation.product_variation_id AS product_variation_id,
                    SUM(order_product_variation.quantity) AS quantity
                FROM order_product_variation
                GROUP BY order_product_variation.product_variation_id
            ) AS order_product_variation ON order_product_variation.product_variation_id = product_variations.id;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('
            DROP VIEW IF EXISTS product_variation_stock_view;
        ');
    }
}
