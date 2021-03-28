<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use withFaker;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->setBaseRoute('users');
        $this->setBaseModel('App\Models\User');
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        $this->attributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ];
    }

    /** @test  */
    public function update_user()
    {
        $this->signInAdmin();
        $this->update($this->attributes);
    }
}
