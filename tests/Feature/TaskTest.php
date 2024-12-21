<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_index(): void
    {
        $response = $this->get('/api/tasks');
        $response->assertStatus(200);
    }
    public function test_store(): void
    {
        $response = $this->post('/api/tasks', [
            'title' => 'teste',
            'status_id' => 1
        ]);
        $response->assertStatus(200);
    }
    public function test_show(): void
    {
        $response = $this->get('/api/tasks/1');
        $response->assertStatus(200);
    }
    public function test_update(): void
    {
        $response = $this->put('/api/tasks/1', [
            'title' => 'teste',
            'status_id' => 2
        ]);
        $response->assertStatus(200);
    }
    public function test_destroy(): void
    {
        $response = $this->delete('/api/tasks/1');
        $response->assertStatus(200);
    }
}
