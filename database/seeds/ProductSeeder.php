<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->insert([
            'name'    => 'product_name',
            'summary' => 'product_summary',
            'preview' => 'preview_url',
            'content' => 'product_content',
            'price'   => '5.02',
        ]);
    }
}
