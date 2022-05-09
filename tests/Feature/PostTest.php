<?php

namespace Tests\Feature;

use App\Models\Categories;
use App\Models\Post;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    /** @test */
    public function show_all_post()
    {
        $response = $this->get(route('post.index'));
        $response->assertStatus(200);
    }


    /** @test */
    public function show_detail_post()
    {
        Categories::create([
            'name' => 'Programming'
        ]);
        $post = Post::factory()->make();
        $response = $this->get('api/v1/posts/' . $post->id, $post->toArray());
        $response->assertStatus(200);
    }

    /** @test */
    public function create_new_post()
    {
        Storage::fake('image');
        Categories::create([
            'name' => 'Programming'
        ]);
        // $post = Post::factory()->make();
        $response = $this->post(route('post.store'), [
            'category_id' => 1,
            'title' => 'post 1',
            'content' => 'my first post',
            'status' => 'publish',
            'image' => UploadedFile::fake()->image('avatar.jpg'),
        ]);
        // $response->assertStatus(200);
        $response->assertOk();
    }
    /** @test */
    public function update_post()
    {
        Storage::fake('image');
        Categories::create([
            'name' => 'Programming'
        ]);
        $post = Post::factory()->make();
        $response = $this->post('api/v1/posts/' . $post->id, [
            'category_id' => 2,
            'title' => 'post 1',
            'content' => 'my first post',
            'status' => 'publish',
            'image' => UploadedFile::fake()->image('avatar.jpg'),
        ]);
        // $response->assertStatus(200);
        $response->assertOk();
    }

    /** @test */
    public function delete_post()
    {
        Storage::fake('image');
        Categories::create([
            'name' => 'Programming'
        ]);
        $post = Post::create([
            'category_id' => 1,
            'title' => 'post 1',
            'content' => 'my first post',
            'status' => 'publish',
            'image' => UploadedFile::fake()->image('avatar.jpg'),
        ]);
        $this->json('delete', 'api/v1/posts/' . $post->id)->assertOk();
    }
}
