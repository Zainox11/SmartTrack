<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function edit()
    {
        return view('client.account', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:100','phone'=>'nullable|string|max:20','company'=>'nullable|string|max:100']);
        Auth::user()->update($data);
        return back()->with('success','Profile updated!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate(['current_password'=>'required','new_password'=>['required',Password::min(6)],'new_password_confirmation'=>'required|same:new_password']);
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password'=>'Current password is incorrect.']);
        }
        Auth::user()->update(['password'=>Hash::make($request->new_password)]);
        return back()->with('success','Password changed!');
    }
}
