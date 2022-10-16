<?php

namespace Tests\Feature;

use Tests\TestCase;

class PostTest extends TestCase
{
    /** @test */
    public function can_create_post()
    {
        // Prepare payload
        $data = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        //$response = $this->get('/');
        //$response->dumpHeaders();
        //$response->dumpSession();
        //$response->dump();

        // Make request
        $response = $this->postJson('api/v1/posts', $data);

        // Test response status
        $response->assertStatus(201)
            ->assertJson(compact('data'));

        $this->assertDatabaseHas('posts', [
            'title' => $data['title']
        ]);
    }
}
