<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function item_can_be_added_to_the_cart()
    {
        Product::factory()->count(3)->create();

        $this->post('/cart', [
            'id' => 1
        ])
            ->assertRedirect('/cart')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('cart.0', [
                'id' => 1,
                'qty' => 1,
            ]);
    }


    /** @test */
    public function same_item_cannot_be_added_to_the_cart_twice()
    {
        Product::factory()->create([
            'name' => 'KTM 1090',
            'price' => 1000.5,
        ]);
        Product::factory()->create([
            'name' => 'KTM 1190',
            'price' => 3000,
        ]);
        Product::factory()->create([
            'name' => 'KTM 1290',
            'price' => 3000.2,
        ]);

        $this->post('/cart', [
            'id' => 1, // Ktm 1090
        ]);
        $this->post('/cart', [
            'id' => 1, // KTM 1090
        ]);
        $this->post('/cart', [
            'id' => 2, // KTM 1190
        ]);

        $this->assertEquals(2, count(session('cart')));
    }

    /** @test */
    public function cart_page_can_be_accessed()
    {
        Product::factory()->count(3)->create();

        $this->get('/cart')->assertStatus(200);
    }

    /** @test */
    public function items_added_to_the_cart_can_be_seen_in_the_cart_page()
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

        $this->post('/cart', [
            'id' => 1, // KTM 1090
        ]);
        $this->post('/cart', [
            'id' => 3, // KTM 1290
        ]);

        $cart_items = [
            [
                'id' => 1,
                'qty' => 1,
                'name' => 'KTM 1090',
                'image' => 'some-image.jpg',
                'price' => 1000,
            ],
            [
                'id' => 3,
                'qty' => 1,
                'name' => 'KTM 1290',
                'image' => 'some-image.jpg',
                'price' => 1000,
            ],
        ];

//         $this->get('/cart')
//             //->assertViewHas('cart_items', $cart_items)
//             ->assertSeeTextInOrder([
//                 'KTM 1090',
//                 'KTM 1290',
//             ])
//             ->assertDontSeeText('KTM 1190');

    }

    /** @test */
    public function item_can_be_removed_from_the_cart()
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

        // add items to session
        session(['cart' => [
            ['id' => 2, 'qty' => 1], // KTM 1190
            ['id' => 3, 'qty' => 3], // KTM 1290
        ]]);

        $this->delete('/cart/2') // remove "KTM 1190"
        ->assertRedirect('/cart')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('cart', [
                ['id' => 3, 'qty' => 3]
            ]);

        // verify that cart page is showing the expected items
        $this->get('/cart')
            ->assertSeeInOrder([
                'KTM 1290', // item name
                '1000', // cost
                '3', // qty
            ])
            ->assertDontSeeText('KTM 1190');

    }

    /** @test */
    public function cart_item_qty_can_be_updated()
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

        // add items to session
        session(['cart' => [
            ['id' => 1, 'qty' => 1], // KTM 1090
            ['id' => 3, 'qty' => 1], // KTM 1290
        ]]);

        $this->patch('/cart/3', [ // update qty of BBQ to 5
            'qty' => 5,
        ])
            ->assertRedirect('/cart')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('cart', [
                ['id' => 1, 'qty' => 1],
                ['id' => 3, 'qty' => 5],
            ]);

        // verify that cart page is showing the expected items
        $this->get('/cart')
            ->assertSeeInOrder([
                // Item #1
                'KTM 1090',
                '1000',
                '1',

                // Item #2
                'KTM 1290',
                '1000',
                '5',
            ]);

    }
}
