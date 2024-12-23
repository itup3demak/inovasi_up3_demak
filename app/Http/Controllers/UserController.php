<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function index()
    {
        $data['title'] = 'SIMASTER';
        if (Auth::check()) {
            return redirect('/beranda');
        } else {
            return view('login', $data);
        }
    }
    public function register_app_simaster()
    {
        $data['title'] = 'Registrasi';
        return view('register_app_simaster', $data);
    }
    public function register_user()
    {
        $data['title'] = 'Registrasi';
        return view('register_user', $data);
    }
    public function register()
    {
        $data['title'] = 'Registrasi';
        return view('register', $data);
    }
    public function authenticate(Request $request)
    {
        $message = [
            'required' => ':attribute harus diisi',
        ];
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], $message);
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $request->session()->put('role', $user->role);
            if($user->role == 'user'){
                return redirect()->intended('user');
            }else if($user->role == 'koordinator'){
                return redirect()->intended('koordinator');
            }else if($user->role == 'mitra'){
                return redirect()->intended('keypoint');
            }else{
                return redirect()->intended('beranda');
            }
        } else {
            Session::flash('error_login', 'Login Failed');
            return redirect('/');
        }
    }
    public function store(Request $request)
    {
        $message = [
            'required' => ':attribute harus diisi',
            'role.in' => ':attribute harus dipilih',
            'max' => ':attribute maximal 255 kata/angka',
            'min' => ':attribute minimal 2 kata/angka',
            'email' => ':attribute tidak valid',
            'unit_ulp.required_if' => 'Unit ULP harus diisi jika role adalah User',
            'unit_ulp.in' => 'Unit ULP yang dipilih tidak valid',
        ];
        $validateData = $request->validate([
            'name' => 'required|max:255|min:2',
            'username' => 'required|max:255|min:5',
            'email' => 'required|email:dns|unique:App\Models\User,email',
            'password' => 'required|min:5|max:255|confirmed',
            'role' => 'required|in:administrator,koordinator,user,mitra',
            'unit_ulp' => 'required_if:role,user|in:ulp demak,ulp tegowanu,ulp purwodadi,ulp wirosari',
        ], $message);
        // event(new Registered($validateData));
        $validateData['password'] = Hash::make($validateData['password']);
        $user = User::create($validateData);
        // event(new Registered($user));
        // Auth::login($user);
        return redirect('/');
    }
    public function edit_user_simaster($id)
    {
        $layout = '';
    
        switch (auth()->user()->role) {
            case 'administrator':
                $layout = 'layout/templateberanda';
                break;
            case 'koordinator':
                $layout = 'layout/templateberanda_koordinator';
                break;
            case 'user':
                $layout = 'layout/templateberanda_user';
                break;
            case 'mitra':
                $layout = 'layout/templateberanda_mitra';
                break;
            default:
                $layout = 'layout/default';
                break;
        }
    
        $data = [
            'title' => 'Edit User SIMASTER',
            'user' => User::find($id),
            'layout' => $layout
        ];
    
        return view('edit_user_simaster', $data);
    }
    
    public function proses_edit_user_simaster(Request $request, $id)
    {
        $message = [
            'required' => ':attribute harus diisi',
            'role.in' => ':attribute harus dipilih',
            'max' => ':attribute maksimal 255 kata/angka',
            'min' => ':attribute minimal 2 kata/angka',
            'email' => ':attribute tidak valid',
        ];
        
        $validateData = $request->validate([
            'name' => 'required|max:255|min:2',
            'username' => 'required|max:255|min:5',
            'email' => 'required|email:dns|unique:users,email,'.$id,
            'password' => 'required|min:5|max:255|confirmed',
            'password_lama' => 'required',
        ], $message);
        
        $user = User::find($id);
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai']);
        }
        if($request->filled('password')) {
            $validateData['password'] = Hash::make($validateData['password']);
        } else {
            unset($validateData['password']);
        }
        
        $user->update($validateData);
        
        switch (auth()->user()->role) {
            case 'administrator':
                return redirect('/beranda');
            case 'koordinator':
                return redirect('/koordinator');
            case 'user':
                return redirect('/user');
            case 'mitra':
                return redirect('/mitra');
            default:
                return redirect('/');
        }
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}