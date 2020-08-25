<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Mockery\Matcher\HasKey;

class UserController extends Controller
{
    /**
     * Register anew user 
     * @api POST /app/user 
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'bail|required|unique:users|max:255',
            'password' => 'required',
        ]);
        $creds = $request->only(['username', 'password']);
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
        if ($user) return response()->json(['staus' => 'account created']);
        return response()->json(['error']);
    }

    /**
     * Authenticate the user 
     * @api POST /app/user/auth
     */
    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if ( !Hash::check($request->password, $user->password) ) {
            return response()->json('UnAuthorized', 401);
        }

        return response()->json([
            'status' => 'success',
            'userId' => $user->id
        ]);
    }

    /**
     * Create a Note 
     * @api post 
     */
    public function create(Request $request)
    {
        $userId = $request->user;

        if (!$userId) return response()->json('userId not provided', 401);

        $user = User::find($userId);
        $note = $user->notes()->create([
            'note' => Crypt::encryptString($request->note)
        ]);

        if ( !$note ) {
            return response()->json('Error While Creating a note', 500);
        }

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * List all the notes  
     * @api GET
     */

    public function list(Request $request)
    {
        $userId = $request->user;

        if (!$userId) return response()->json('userId not provided', 401);
        $user = User::find($userId);
        $notes = $user->notes()->get();
        foreach ($notes as $item) {
            $item->note = Crypt::decryptString($item->note);
        }
        return $notes;
    }
}
