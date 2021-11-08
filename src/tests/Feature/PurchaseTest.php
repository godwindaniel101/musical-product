<?php

namespace Tests\Feature;

use Tests\AuthCase;

class PurchaseTest extends AuthCase
{
    /** @test */

    public function test_all_product_created_by_a_user()
    {
        $response = $this->get('/api/user/products');
        
        $response->assertStatus(200);
    }

    public function test_user_creating_purchase_product()
    {
        $this->post('/api/products', ["name" => "New Product"]);

        $response = $this->post('/api/user/products', ['product_sku' => 'new-product']);

        $data =  $response->getOriginalContent();

        $response->assertStatus(201);

        $this->assertEquals($data['message'], "Purchase recorded attached successfully.");
    }

    public function test_user_can_only_purchase_valid_product()
    {
        $response = $this->delete('/api/user/products/new-product', ['product_sku' => 'invalid-product']);

        $data =  $response->getOriginalContent();

        $response->assertStatus(422);

        $this->assertEquals('The selected product sku is invalid.',  $data['data']->first());
    }


    public function test_user_can_only_purchase_product_once()
    {
        $this->post('/api/products', ["name" => "New Product"]);

        $this->post('/api/user/products', ['product_sku' => 'new-product']);

        $response = $this->post('/api/user/products', ['product_sku' => 'new-product']);

        $data =  $response->getOriginalContent();

        $response->assertStatus(422);

        $this->assertEquals("You already have this item purchased.",$data['data']);
    }

    public function test_user_deleting_purchase_product()
    {
        $this->post('/api/products', ["name" => "New Product"]); //create product

        $this->post('/api/user/products', ['product_sku' => 'new-product']); //create purcase

        $response = $this->delete('/api/user/products/new-product', ['product_sku' => 'new-product']);

        $data =  $response->getOriginalContent();

        $response->assertStatus(200);

        $this->assertEquals($data['message'], "Purchase Record detached successfully.");
    }

    public function test_user_can_only_delete_valid_product()
    {
        $response = $this->delete('/api/user/products/new-product', ['product_sku' => 'invalid-product']);

        $data =  $response->getOriginalContent();

        $response->assertStatus(422);

        $this->assertEquals('The selected product sku is invalid.',  $data['data']->first());
    }

    
}
