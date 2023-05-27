<?php

namespace App\Http\Controllers;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{
     // all users
     public function index()
     {   
         $users = User::where('id', '<>', Auth::id())->get()->toArray();
         return array_reverse($users);
     }
 
     // add user
     public function add(Request $request)
     {
         $user = new User([
             'name'     => $request->name,
             'email'    => $request->email,
             'password' => $request->password
         ]);
         $user->save();
 
         return response()->json('The user successfully added');
     }
 
     // edit user
     public function edit($id)
     {
         $user = User::find($id);
         return response()->json($user);
     }
 
     // update user
     public function update($id, Request $request)
     {
         $user = User::find($id);
         $user->update($request->all());
 
         return response()->json('The user successfully updated');
     }
 
     // delete user
     public function delete($id)
     {
         $user = User::find($id);
         $user->delete();
 
         return response()->json('The user successfully deleted');
     }

     public function import() 
     {
        Excel::import(new UserImport, $request->file('file')->store('temp'));
        return back();
     }

     public function export() 
     {
        // use Excel facade to export data, by passing in the UserExport class and the desired file name as arguments
        return Excel::download(new UserExport, 'users.xlsx');
     }

}