<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class DeleteBlogTest extends TestCase
{
    use withFaker;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->setBaseRoute('blogs');
        $this->setBaseModel('App\Models\Blog');

    }
    /** @test  */
    public function delete_user_blog()
    {
        $this->signInAdmin();
        $this->destroy()->assertStatus(202);
    }
}
