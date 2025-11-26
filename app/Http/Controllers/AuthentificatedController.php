<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function Laravel\Prompts\error;

class AuthentificatedController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
                'message' => 'Validation échoué',
            ], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'data' => $user,
        ]);
    }
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
                'message' => 'Connexion failed',
            ], 400);
        }
        $user = User::where('email', $request->email)->get()->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $accessToken = $user->createToken('authToken')->accessToken;
            $refreshToken = $user->createToken('refreshToken')->accessToken;

            return response()->json([
                "sucess" => true,
                'message' => 'Connexion réussi',
                'data' => $user,
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,

            ]);
        }
        return response()->json([
            'message' => 'Email ou mot de passe incorrect',
        ], 400);
    }

    public function logout(Request $request){

        $request->user()->tokens()->revoke();

        return response()->json([
            'message'=>'Déconnexion effectuée',
        ]);
    }

    public function createRole() {
        $adminRole = Role::create(['name' => 'admin']);
        $permission = Permission::create(['name' => 'add service']);
        $permission = Permission::create(['name' => 'add reservation']);
        $permission = Permission::create(['name' => 'add abonnement']);
        $permission = Permission::create(['name' => 'edit service']);
        $permission = Permission::create(['name' => 'edit reservation']);
        $permission = Permission::create(['name' => 'edit abonnement']);
        $permission = Permission::create(['name' => 'delete service']);
        $permission = Permission::create(['name' => 'delete reservation']);
        $permission = Permission::create(['name' => 'delete abonnement']);

        $role->givePermission($permission);
        $permission->assignRole($role);
    }

}
