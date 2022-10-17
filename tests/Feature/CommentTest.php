<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * Test for create a comment.
     *
     * @return void
     */
    public function test_create_comment()
    {
        $data = [
            'name' => 'John Doe',
            'message' => 'Lorem ipsum dolor si team'
        ];
        $response = $this->json('POST', '/api/posts/1/comments/99/create', $data);
        $response->assertStatus(200);
    }

    /**
     * Test for update a comment.
     *
     * @return void
     */
    public function test_update_comment()
    {
        $data = [
            'name' => 'John Doe edited',
            'message' => 'Lorem ipsum dolor si team edited'
        ];
        $response = $this->json('PATCH', '/api/posts/1/comments/99/update', $data);
        $response->assertStatus(200);
    }

    /**
     * Test for Delete a comment.
     *
     * @return void
     */
    public function test_delete_comment()
    {
        $response = $this->json('DELETE', '/api/posts/1/comments/101/delete');
        $response->assertStatus(200);
    }
}
