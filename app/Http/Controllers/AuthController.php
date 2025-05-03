<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        $admin = User::where('email', $request->email)->first();
        if($admin) {
            if(auth::guard('web')->attempt($credentials, $remember)) {
                return redirect()->route('dashboard')->with('success'. 'You are success login as administrator!');
            }
        return back()->withErrors(['password' => 'Login failed, please check your password.',])->onlyInput('email');
        }

        return back()->withErrors(['email' => 'Email or username is not registered',])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    public function forgotPassword () {
        return view('admin.auth.forgot-password');
    }

    public function resetLink (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm ($token) {
        return view('admin.auth.reset-password', ['token' => $token]);
    }

    // public function resetPassword(Request $request){
    //     // Validate the request data
    //     $request->validate([
    //         'token' => 'required',
    //         'email' => 'required|email', // Ensure the email exists in the users table
    //         'password' => 'required|min:8|confirmed',
    //     ]);

    //     // Check if the token is valid for the given email in the password_resets table
    //     $passwordReset = DB::table('password_reset_tokens')
    //         ->where('email', $request->email)
    //         ->where('token', $request->token)
    //         ->first();

    //     // Proceed with resetting the password if the token is valid
    //     $status = Password::reset(
    //         $request->only('email', 'password', 'password_confirmation', 'token'),
    //         function (User $user, string $password) {
    //             $user->forceFill([
    //                 'password' => Hash::make($password)
    //             ])->setRememberToken(Str::random(60));
    //             $user->save();
    //             event(new PasswordReset($user));
    //         }
    //     );

    //     if ($status == Password::PASSWORD_RESET) {
    //         // Success, return a JSON response with success message
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Your password has been reset successfully!',
    //         ]);
    //     } else {
    //         // Error, return a JSON response with the error message
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => __($status),
    //         ]);
    //     }
    // }

    
    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    // dd($request->all());
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function edit(){
        return view('admin.auth.account');
    }

    public function update(Request $request)
    {
        $user = Auth()->user();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'         => 'nullable|string|max:20',
            'password'      => 'nullable|min:6',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update basic data
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Update profile photo with Spatie Media Library
        if ($request->hasFile('profile_photo')) {
            // Remove existing photo if any (optional)
            $user->clearMediaCollection('profile');

            // Add new photo to media collection named "profile"
            $user->addMediaFromRequest('profile_photo')->toMediaCollection('profile');
        }

        $user->save();

        return back()->with('success', 'Akun berhasil diperbarui.');
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        
        // Hapus gambar lama jika ada
        if ($user->hasMedia('profile')) {
            $user->getFirstMedia('profile')->delete();
        }

        // Upload gambar baru
        $user->addMediaFromRequest('profile_image')
            ->toMediaCollection('profile');

        // return redirect()->route('account.edit');
        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diupload',
            'new_image_url' => $user->getFirstMediaUrl('profile') // ← ini penting
        ]);
        

        // return response()->json(['success' => true, 'new_image_url' => $user->getFirstMediaUrl('profile')]);
    }
    
}
