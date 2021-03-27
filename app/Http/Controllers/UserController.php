<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\registerRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getAllUsers(): JsonResponse
    {
        $users = User::query()->get();
        return response()->json($users, 200);
    }

    /**
     * @param User $user
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function getUser(User $user) {
            return response($user, 200);
    }

    /**
     * @param registerRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function create(registerRequest $request)
    {
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::query()->create($request->toArray());
        $token = $user->createToken('Register User')->accessToken;
        $response = ['user' => $user, 'token' => $token];
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user): JsonResponse
    {
        if ($user::query()->exists()) {

            $user->name = is_null($request->name) ? $user->name : $request->name;
            $user->email = is_null($request->email) ? $user->email : $request->email;
            $user->password = is_null($request->password) ? $user->password : Hash::make($request['password']);
            $user->save();

            return response()->json([
                "message" => "records updated successfully",
                "data" => $user
            ], 200);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete (User $user): JsonResponse
    {
        if($user::query()->exists()) {
            $user->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }



}
