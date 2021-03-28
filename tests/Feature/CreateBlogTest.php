<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

use Tests\TestCase;

class CreateBlogTest extends TestCase
{
    use withFaker;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->setBaseRoute('blogs');
        $this->setBaseModel('App\Models\Blog');
    }

    /** @test */
    public function blog_create()
    {
        $this->signIn();
        $this->create();
    }

    /** @test */
    public function unauth_create()
    {
        $this->create();
    }
}
