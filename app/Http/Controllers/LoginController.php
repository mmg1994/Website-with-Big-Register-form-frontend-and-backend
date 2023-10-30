<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // view
    public function index()
    {
        return view('register');
    }
    // get data from form
    public function storeRegister(Request $request)
    {
         // Validate the form input
         $validatedData = $request->validate([

            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:registers',
            'password'   => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'gender' => 'required|in:male,female',
            'francais' => 'nullable',
            'anglais' => 'nullable',
            'checkpasseport' => 'required|in:non,oui',
            'passport' => 'nullable|required_if:checkpasseport,oui',
            'date_of_birth' => 'required|date',
            'marital_status' => 'required|in:single,married',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        


        // Handle the checkbox values
        $francais = $request->has('francais') ? 1 : 0;
        $anglais = $request->has('anglais') ? 1 : 0;

        // Handle the passport field
       
        $passport = $request->input('passport');
        $hasPassport = $request->input('checkpasseport') === 'oui';

        if (!$hasPassport) {
            $passport = null;
        }

        // Handle the profile image upload
        $profileImage = null;
        if ($request->hasFile('profile_image')) {
            $uploadedFile = $request->file('profile_image');
            $profileImage = $uploadedFile->store('profile_images', 'public'); // You can modify the storage path as per your needs
        }


            // Create a new user record
            $user = new User();
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
            $user->email = $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->gender = $validatedData['gender'];
            $user->francais = $francais;
            $user->anglais = $anglais;
            $user->has_passport = $hasPassport;
            $user->passport = $passport;
            $user->date_of_birth = $validatedData['date_of_birth'];
            $user->marital_status = $validatedData['marital_status'];
            $user->profile_image = $profileImage;
            $user->save();

            // Perform any additional actions or redirect as needed

        //     return response()->json(['success' => true]);
        return redirect('home/page');

    }
    // view
    public function viewLogin()
    {
        return view('login');
    }

    // login
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string',
        ]);

        $email    = $request->email;
        $password = $request->password;
        
        if(Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return redirect()->intended('home/page');
        }
        return redirect('login/view/new')->with('error','Wrong Password or Username');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('login/view/new');
    }
}
