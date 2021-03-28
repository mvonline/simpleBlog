<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use withFaker;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->setBaseRoute('users');
        $this->setBaseModel('App\Models\User');

    }
    /** @test  */
    public function delete()
    {
        $this->signInAdmin();
        $this->destroy()->assertStatus(202);
    }
}
