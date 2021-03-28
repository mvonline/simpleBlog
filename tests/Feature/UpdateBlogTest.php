<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UpdateBlogTest extends TestCase
{
    use withFaker;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->setBaseRoute('blogs');
        $this->setBaseModel('App\Models\Blog');
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        $this->attributes = [
            'title' => $this->faker->sentence,
            'text' => $this->faker->text
        ];
    }

    /** @test  */
    public function update_blog()
    {
        $this->signInAdmin();
        $this->update($this->attributes);
    }

    /** @test  */
    public function update_blog_user()
    {
        $this->signIn();
        $this->update($this->attributes);
    }


}
