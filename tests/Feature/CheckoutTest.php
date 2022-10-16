<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cart_items_can_be_seen_from_the_checkout_page()
    {
        Product::factory()->create([
            'name' => 'KTM 1090',
            'image' => 'some-image.jpg',
            'price' => 1000,
        ]);
        Product::factory()->create([
            'name' => 'KTM 1190',
            'image' => 'some-image.jpg',
            'price' => 1000,
        ]);
        Product::factory()->create([
            'name' => 'KTM 1290',
            'image' => 'some-image.jpg',
            'price' => 1000,
        ]);

        session([
            'cart' => [
                ['id' => 2, 'qty' => 1], // KTM 1190
                ['id' => 3, 'qty' => 2], // KTM 1290
            ],
        ]);

        $checkout_items = [
            [
                'id' => 2,
                'qty' => 1,
                'name' => 'KTM 1190',
                'price' => 1000,
                'subtotal' => 1000,
            ],
            [
                'id' => 3,
                'qty' => 2,
                'name' => 'KTM 1290',
                'price' => 1000,
                'subtotal' => 2000,
            ],
        ];

        $this->get('/checkout')
            ->assertViewIs('checkout')
            ->assertViewHas('checkout_items', $checkout_items)
            ->assertSeeTextInOrder([
                // Item #1
                'KTM 1190',
                '1000',
                '1x',
                '1000',

                // Item #2
                'KTM 1290',
                '1000',
                '2x',
                '2000',

                '3000', // total
            ]);
    }

    /** @test */
    public function order_can_be_created()
    {
        Product::factory()->create([
            'name' => 'KTM 1090',
            'image' => 'some-image.jpg',
            'price' => 1000,
        ]);
        Product::factory()->create([
            'name' => 'KTM 1190',
            'image' => 'some-image.jpg',
            'price' => 1000,
        ]);
        Product::factory()->create([
            'name' => 'KTM 1290',
            'image' => 'some-image.jpg',
            'price' => 1000,
        ]);

        // add items to cart
        $this->post('/cart', [
            'id' => 1, // KTM 1090
        ]);
        $this->post('/cart', [
            'id' => 2, // KTM 1190
        ]);
        $this->post('/cart', [
            'id' => 3, // KTM 1290
        ]);

        // update qty of taco to 5
        $this->patch('/cart/1', [
            'qty' => 5,
        ]);

        // remove pizza
        $this->delete('/cart/2');

        $this->post('/checkout')
            ->assertSessionHasNoErrors()
            ->assertRedirect('/summary?order_id=1');

        // check that the order has been added to the database
        $this->assertDatabaseHas('orders', [
            'total' => 6000,
        ]);

        $this->assertDatabaseHas('order_details', [
            'order_id' => 1,
            'product_id' => 1,
            'price' => 1000,
            'qty' => 5,
        ]);

        $this->assertDatabaseHas('order_details', [
            'order_id' => 1,
            'product_id' => 3,
            'price' => 1000,
            'qty' => 1,
        ]);
    }
}
