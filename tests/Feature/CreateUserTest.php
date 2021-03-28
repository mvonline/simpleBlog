<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use withFaker;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->setBaseRoute('users');
        $this->setBaseModel('App\Models\User');

    }

    /** @test */
    public function user_create()
    {
        $this->signInAdmin();
        $this->create();
    }

    /** @test */
    public function unauth_create()
    {
        $this->create();
    }
}
