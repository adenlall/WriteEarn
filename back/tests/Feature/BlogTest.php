<?php

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\User;

beforeEach(function () {
    $user = User::factory()->create([
        'password' => bcrypt('pass123@@3'),
    ]);
    $login_response = $this->post('/api/login', [
        'email' => $user->email,
        'password' => 'pass123@@3',
    ]);
    $login_response->assertStatus(200);
    $token = $login_response->json()['token'];
    $this->reader_token = $token;
    $this->reader = $user;

    $user = User::factory()->create([
        'password' => bcrypt('pass123@@3'),
        'role' => 'publisher',
    ]);
    $login_response = $this->post('/api/login', [
        'email' => $user->email,
        'password' => 'pass123@@3',
    ]);
    $login_response->assertStatus(200);
    $token = $login_response->json()['token'];
    $this->publisher_token = $token;
    $this->publisher = $user;

    $login_response = $this->post('/api/login', [
        'email' => 'ade@lall.me',
        'password' => '0',
    ]);
    $login_response->assertStatus(200);
    $token = $login_response->json()['token'];
    $this->admin_token = $token;
    $this->admin = $user;
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
