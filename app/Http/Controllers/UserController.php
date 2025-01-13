<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function getNameById(Request $request): JsonResponse
    {
        // Retrieve the encrypted user ID from the request headers
        $encryptedUserId = $request->header('user_id');

        try {
            // Decrypt the user ID
            $userId = Crypt::decryptString($encryptedUserId);
        } catch (\Exception $e) {
            // Return an error if decryption fails
            return response()->json(['error' => 'Invalid user ID'], 400);
        }

        // Fetch the user's name from the database by the decrypted ID
        $user = DB::table('users')->where('id', $userId)->first();

        // Check if the user exists
        if ($user) {
            return response()->json(['name' => $user->name]);
        }

        // Return an error if the user was not found
        return response()->json(['error' => 'User not found'], 404);
    }


    public function getAllNames(): JsonResponse
    {
        // Fetch all user names from the 'users' table
        $users = DB::table('users')->pluck('name');

        // Check if any users were found
        if ($users->isEmpty()) {
            return response()->json(['error' => 'No users found'], 404);
        }

        // Return the list of names in JSON format
        return response()->json(['names' => $users]);
    }
}
