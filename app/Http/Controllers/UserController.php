<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Model\{User, Product, Category, UserLevel};

class UserController extends Controller
{
    //---Liste des utilisateur
    public function user_all_view(Request $request)
    {
        $Users = User::orderBy('firstname', 'ASC')->orderBy('lastname', 'ASC')->get();

        $param = [
          "title" => "Utilisateurs",
          "pIndex" => "user.all",
          "Users" => $Users
        ];

        return view('user.all', $param);
    }

    //---Nouvel utilisateur
    public function user_new_view(Request $request)
    {
        $UserLevels = UserLevel::orderBy('name', 'ASC')->get();

        $param = [
          "title" => "Nouvel Utilisateur",
          "pIndex" => "user.all",
          "UserLevels" => $UserLevels
        ];

        return view('user.new', $param);
    }

    public function user_new(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userLevelCode' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'userLevelCode' => $request->userLevelCode,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make(config('global.default_password')),

        ]);
        if($request->file('img')){
            $file = $request->file('img');
            $filename = 'user-' . $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(config('global.image_user'), $filename);

            $user->img = $filename;
        }
        $user->save();

        $request->session()->flash('ess-msg', "L'utilisateur à été ajouté");
        return redirect()->route('user.infos', [$user->id]);
    }

    //---Information sur un utilisateur
    public function user_infos_view(Request $request, $userId)
    {
        $UserLevels = UserLevel::orderBy('name', 'ASC')->get();
        $User = User::where('id', $userId)->first();
        if($User==null) return redirect()->route('user.all');

        $param = [
          "title" => "Utilisateur",
          "pIndex" => "user.infos",
          "UserLevels" => $UserLevels,
          "User" => $User
        ];

        return view('user.infos', $param);
    }

    public function user_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric',
            'userLevelCode' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $User = User::where('id', $request->userId)->first();
        if($User==null) return redirect()->back();

        $User->userLevelCode = $request->userLevelCode;
        $User->firstname = $request->firstname;
        $User->lastname = $request->lastname;
        $User->email = $request->email;
        $User->phone = $request->phone;
        $User->enabled = $request->enabled;
        if($request->password) $User->password = Hash::make($request->password);
        if($request->file('img')){
            $file = $request->file('img');
            $filename = 'user-' . $User->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(config('global.image_user'), $filename);

            $User->img = $filename;
        }
        $User->save();

        $request->session()->flash('ess-msg', "L'utilisateur à été modifier");
        return redirect()->route('user.infos', [$User->id]);
    }

    public function user_remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $User = User::where('id', $request->userId)->first();
        if($User==null) return redirect()->back();
        $User->delete();

        $request->session()->flash('ess-msg', "L'utilisateur à été suprimé");
        return redirect()->back();
    }
}
