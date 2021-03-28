<?php

namespace Tests;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $base_route = null;
    protected $base_model = null;


    protected function signIn($user = null): TestCase
    {
        $user = $user ?? create(User::class);
        $this->actingAs($user);
        return $this;
    }

    protected function signInAdmin($user = null): TestCase
    {
        $user = $user ?? create(User::class);
        $role = new Role();
        $role->name = "admin";
        $role->save();
        $user->assignRole('admin');
        $this->actingAs($user);
        return $this;
    }

    protected function setBaseRoute($route)
    {
        $this->base_route = $route;
    }

    protected function setBaseModel($model)
    {
        $this->base_model = $model;
    }

    protected function create($attributes = [], $model = '', $route = ''): TestResponse
    {
        $this->withoutExceptionHandling();
        $header = ['Accept' => 'application/json'];
        $route = $this->base_route ? "{$this->base_route}.store" : $route;
        $model = $this->base_model ?? $model;
        $attributes = raw($model, $attributes);
        if (! auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }else {
            $token = auth()->user()->createToken('Login User - Feature Test')->accessToken;
            $header['Authorization'] = 'Bearer ' . $token;
        }

        $response = $this->postJson(route($route), $attributes,$header)->assertSuccessful();

        //because of password encryption
        if($model != 'App\Models\User') {
            $model = new $model;
            $this->assertDatabaseHas($model->getTable(), $attributes);
        }
        return $response;
    }

    protected function update($attributes = [], $model = '', $route = '')
    {
        $this->withoutExceptionHandling();
        $header = ['Accept' => 'application/json'];

        $route = $this->base_route ? "{$this->base_route}.update" : $route;
        $model = $this->base_model ?? $model;

        $model = create($model);

        if (! auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }else {
            $token = auth()->user()->createToken('Login User - Feature Test')->accessToken;
            $header['Authorization'] = 'Bearer ' . $token;
        }

        $response = $this->putJson(route($route, $model->id), $attributes,$header);
        tap($model->fresh(), function ($model) use ($attributes) {
            collect($attributes)->each(function($value, $key) use ($model) {
                $this->assertEquals($value, $model[$key]);
            });
        });

        return $response;
    }

    protected function destroy($model = '', $route = ''): TestResponse
    {
        $this->withoutExceptionHandling();
        $header = ['Accept' => 'application/json'];

        $route = $this->base_route ? "{$this->base_route}.destroy" : $route;
        $model = $this->base_model ?? $model;

        $model = create($model);

        if (! auth()->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }else{
            $token = auth()->user()->createToken('Login User - Feature Test')->accessToken;
            $header['Authorization'] = 'Bearer ' . $token;
        }
        $response = $this->deleteJson(route($route, $model->id),[],$header);
        $m= $model->toArray();
        $m['created_at']=Carbon::parse($model['created_at'])->format('Y-m-d H:i:s');
        $m['updated_at']=Carbon::parse($model['updated_at'])->format('Y-m-d H:i:s');

        $this->assertSoftDeleted($model->getTable(), $m);

        return $response;
    }



}
