<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function vehicle_search_page_is_accessible()
    {
        $this->get('/')
            ->assertStatus(200);
    }

    /** @test */
    public function vehicle_search_page_has_all_the_required_page_data()
    {
        // Create 3 random products
        Product::factory()->count(3)->create();

        // Get all products
        $items = Product::get();



        $response = $this->get('/')
            ->assertSeeInOrder([
                $items[2]->name,
                $items[1]->name,
                $items[0]->name,
            ]);

        // Assert
        $response->assertViewIs('search')->assertViewHas('items', $items);
    }

    /** @test  */
    public function vehicle_can_be_searched_given_a_query()
    {
        Product::factory()->create([
            'name' => 'KTM 1090'
        ]);

        Product::factory()->create([
            'name' => 'KTM 1190'
        ]);

        Product::factory()->create([
            'name' => 'KTM 1290'
        ]);

        $this->get('/?query=KTM+1290')
            ->assertSee('KTM 1290')
            ->assertDontSeeText('KTM 1090')
            ->assertDontSeeText('KTM 1190');

        $this->get('/')->assertSeeInOrder(['KTM 1090', 'KTM 1190', 'KTM 1290']);
    }
}
