<?php

namespace App\Http\Controllers;

use App\Models\Reset;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class ResetController extends Controller
{
    public function resetPasswordEmail(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();
        $token = Str::random(100);

        try {
            $this->validate($request, [
                'email' => 'required|regex:/(.*)@(gmail)\.com/i'
            ]);
        } catch (Exception $e) {
            return response(['message' => 'Invalid format of data'], 400);
        }

        if ($user && DB::table('resets')->where('email', $user->email)->first()) {
            DB::table('resets')->where('email', $user->email)->update(['token' => $token]);
        } else {
            Reset::create([
                'email' => $user->email,
                'token' => $token,
            ]);
        }

        mail($user->email, "Password reset", "Hello! Here is your link to reset password:\n" . URL::current() . '/' . $token);

        return response([
            'message' => 'Reset sent to ' . $user->email . '!',
        ]);
    }

    public function resetPasswordToken(Request $request, $token)
    {
        $data = DB::table('resets')->where('token', $token)->first();
        $user = DB::table('users')->where('email', $data->email)->first();

        if (!$data) {
            return response(['message' => 'Invalid token'], 400);
        } else if (!$user) {
            return response(['message' => 'User does not exist'], 404);
        }

        DB::table('users')->where('email', $data->email)->update(['password' => Hash::make($request->password)]);
        DB::table('resets')->where('email', $data->email)->delete();
        return response(['message' => 'Password reset']);
    }
}
