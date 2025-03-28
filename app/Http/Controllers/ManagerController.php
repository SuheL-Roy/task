<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function create_teammates_list()
    {
        $teammates = User::where('role', '!=', 'Manager')->latest()->get();

        return view('Manager.teamamtes_list', compact('teammates'));
    }

    public function teammates_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',

        ]);

        $teammate = new User();
        $teammate->name = $request->name;
        $teammate->email = $request->email;
        $teammate->role = 'Teammate';
        $teammate->password = $request->password;
        $teammate->save();

        return back()->with('success', 'Teammates created Successfully');
    }

    public function destroy(Request $request)
    {
        User::find($request->id)->delete();
        return back()->with('success', 'Successfully Deleted');
    }
}
