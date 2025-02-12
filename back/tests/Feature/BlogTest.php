<?php

use App\Http\Resources\BlogResource;
use App\Models\Blog;
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
});

describe('blog', function () {

    it('return all blogs', function () {
        $response = $this->actingAs($this->reader)->get('/api/blogs');
        $response->assertStatus(200);
        $response->assertJson(BlogResource::collection(Blog::all())->response()->getData(true));
    });

    it('return one blog', function () {
        $blog = $this->publisher->blogs()->create([
            'title' => Faker\Factory::create()->sentence,
            'slug' => Faker\Factory::create()->slug,
            'description' => Faker\Factory::create()->paragraph,
        ]);
        $response = $this->actingAs($this->publisher)->get('/api/blogs/'.$blog->id);
        $response->assertStatus(200);
        $response->assertJson(BlogResource::make($blog)->response()->getData(true));
    });

    it('return success created blog', function () {
        $response = $this->actingAs($this->publisher)->post('/api/blogs',
            data: [
                'title' => Faker\Factory::create()->sentence,
                'slug' => Faker\Factory::create()->slug,
                'description' => Faker\Factory::create()->paragraph,
            ]
        );
        $response->assertStatus(201);
        $response->assertJson(BlogResource::make(Blog::find($response->json()['data']['id']))->response()->getData(true));
    });

    it('return failed created blog', function () {
        $response = $this->actingAs($this->reader)->post('/api/blogs',
            data: [
                'title' => Faker\Factory::create()->sentence,
                'slug' => Faker\Factory::create()->slug,
                'description' => Faker\Factory::create()->paragraph,
            ],
        );
        $response->assertStatus(403);
    });

    it('return success updated blog', function () {
        $blog = $this->publisher->blogs()->create([
            'title' => Faker\Factory::create()->sentence,
            'slug' => Faker\Factory::create()->slug,
            'description' => Faker\Factory::create()->paragraph,
        ]);
        $response = $this->actingAs($this->publisher)->put('/api/blogs/'.$blog->id,
            data: [
                'title' => Faker\Factory::create()->sentence,
                'slug' => Faker\Factory::create()->slug,
                'description' => Faker\Factory::create()->paragraph,
            ],
        );
        $response->assertStatus(200);
        $response->assertJson(BlogResource::make(Blog::find($blog->id))->response()->getData(true));
    });

});
