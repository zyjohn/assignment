<?php

//didn't figured out a way to define service yet, everything in controller so no way to inject/mock data.
//Use seed to initialize data and test. Just an example
class AdminProductTest extends TestCase {

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testSeeProduct() {
        $this->seed('ProductSeeder');
        $this->visit('/admin/product')
                ->see('product_name');
    }

}
