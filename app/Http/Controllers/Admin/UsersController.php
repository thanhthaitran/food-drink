<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUsersRequest;
use App\UserInfo;
use Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('userInfo')->paginate(config('define.number_pages'));
        return view('admin.user.index', compact('users'));
    }
    /**
     * Show the form for creating a new data.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsers $request)
    {
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        return redirect()->route('user.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user User object
     *
     * @return \Illuminate\Http\Response
    */
    public function edit(User $user)
    {
        $user->load('userInfo');
        return view('admin.user.edit')->with('user', $user);
    }

     /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request request
    * @param User                     $user    object
    *
    * @return \Illuminate\Http\Response
    */
    public function update(UpdateUsersRequest $request, User $user)
    {
        $user->update($request->only(['name']));
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $nameNew = time().'_'.md5(rand(0, 99999)).'.'.$image->getClientOriginalExtension();
            $image->move(public_path(config('define.images_path_users')), $nameNew);
            UserInfo::where('user_id', $user->id)->update([
                'address' => $request->address,
                'phone' => $request->phone,
                'avatar' => $nameNew
            ]);
        } else {
            UserInfo::where('user_id', $user->id)->update([
                'address' => $request->address,
                'phone' => $request->phone,
            ]);
        }
        Session::flash('message', trans('message.user.update'));
        return redirect()->route('user.index');
    }
}
