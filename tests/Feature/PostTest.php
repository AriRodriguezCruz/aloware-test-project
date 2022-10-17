<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * Test for get comments for post.
     *
     * @return void
     */
    public function test_get_post_comments()
    {
        $response = $this->json('GET', '/api/posts/1');
        $response->assertStatus(200);
    }
}
