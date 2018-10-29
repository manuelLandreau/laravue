<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class UserListController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAll(Request $request)
    {
        if (isset($request->name)) {
            return DB::table('users')->orderBy('name', $request->input('name'))->paginate(50);
        } elseif (isset($request->email)) {
            return DB::table('users')->orderBy('email', $request->input('email'))->paginate(50);
        } elseif (isset($request->created_at)) {
            return DB::table('users')->orderBy('created_at', $request->input('created_at'))->paginate(50);
        } elseif (isset($request->queryString)) {
            return DB::table('users')->where('name', 'like', '%' . $request->queryString . '%')->paginate(50);
        }
        return DB::table('users')->paginate(50);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $user= User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return $user;
    }
}
