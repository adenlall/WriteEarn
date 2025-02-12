<?php

use App\Http\Resources\PostResource;
use App\Models\Blog;
use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->reader = User::factory()->create([
        'password' => bcrypt('pass123@@3'),
    ]);
    $this->publisher = User::factory()->create([
        'password' => bcrypt('pass123@@3'),
        'role' => 'publisher',
    ]);
    $this->admin = User::where(
        'email', 'ade@lall.me'
    )->first();

    $this->blog = $this->publisher->blogs()->create([
        'title' => 'test',
        'slug' => 'test',
        'description' => 'test test test',
    ]);
});

describe('post', function () {

    it('return all posts', function () {
        Post::factory()->count(3)->create([
            'blog_id' => $this->blog->id,
        ]);
        $response = $this->actingAs($this->publisher)->get('/api/blogs/'.$this->blog->id.'/posts');
        $response->assertStatus(200);
        $response->assertJson(PostResource::collection(Blog::find($this->blog->id)->posts)->response()->getData(true));
    });

    it('return created posts', function () {
        $response = $this->actingAs($this->publisher)->post('/api/blogs/'.$this->blog->id.'/posts', [
            'title' => Faker\Factory::create()->sentence,
            'content' => Faker\Factory::create()->sentence,
            'slug' => Faker\Factory::create()->slug,
            'expert' => Faker\Factory::create()->name,
        ]);
        $response->assertStatus(201);
        $response->assertJson(PostResource::make(Post::where('id', $response->json()['data']['id'])->first())->response()->getData(true));
    });

    it('return updated post', function () {
        $post = Post::factory()->create([
            'blog_id' => $this->blog->id,
        ]);
        $updateData = [
            'id' => $post->id,
            'title' => Faker\Factory::create()->sentence,
            'content' => Faker\Factory::create()->sentence,
            'slug' => Faker\Factory::create()->slug,
            'expert' => Faker\Factory::create()->name,
        ];
        $response = $this->actingAs($this->publisher)->put('/api/blogs/'.$this->blog->id.'/posts/'.$post->id, $updateData);
        $response->assertStatus(200);
        $response->assertJson(
            array_replace_recursive(
                PostResource::make(Post::make($updateData))->response()->getData(true),
                ['data' => ['id' => $post->id]]
            )
        );
    });

    it('return deleted post', function () {
        $post = Post::factory()->create([
            'blog_id' => $this->blog->id,
        ]);
        $response = $this->actingAs($this->publisher)->delete('/api/blogs/'.$this->blog->id.'/posts/'.$post->id);
        $response->assertStatus(202);
    });

    it('return failed delete post permissions', function () {
        $post = Post::factory()->create([
            'blog_id' => $this->blog->id,
        ]);
        $response = $this->actingAs($this->reader)->delete('/api/blogs/'.$this->blog->id.'/posts/'.$post->id);
        $response->assertStatus(403);
    });

    it('return failed create post permissions', function () {
        $publisher = User::factory()->create([
            'password' => bcrypt('pass123@@3'),
            'role' => 'publisher',
        ]);
        $response = $this->actingAs($publisher)->post('/api/blogs/'.$this->blog->id.'/posts', [
            'title' => Faker\Factory::create()->sentence,
            'content' => Faker\Factory::create()->sentence,
            'slug' => Faker\Factory::create()->slug,
            'expert' => Faker\Factory::create()->name,
        ]);
        $response->assertStatus(403);
    });

    it('return success create post permissions', function () {
        $admin = User::factory()->create([
            'password' => bcrypt('pass123@@3'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($admin)->post('/api/blogs/'.$this->blog->id.'/posts', [
            'title' => Faker\Factory::create()->sentence,
            'content' => Faker\Factory::create()->sentence,
            'slug' => Faker\Factory::create()->slug,
            'expert' => Faker\Factory::create()->name,
        ]);
        $response->assertStatus(201);
    });

});
