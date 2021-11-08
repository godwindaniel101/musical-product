<?php

namespace Tests\Feature;

use Tests\AuthCase;

class ProductTest extends AuthCase
{
    /** @test */
    public function test_user_can_view_all_product()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_user_can_create_a_product()
    {
        $response = $this->post('/api/products', ["name" => "New Product"]);

        $response->assertStatus(201);

        $data =  $response->getOriginalContent();

        $this->assertEquals($data['data']['sku'], "new-product");
    }

    public function test_name_is_required_to_create_a_product()
    {
        $response = $this->post('/api/products', ["name" => ""]);

        $response->assertStatus(422);
    }
}
