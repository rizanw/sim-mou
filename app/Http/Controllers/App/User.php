<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User as ModelsUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.user.list');
    }

    /**
     * Create json data for the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $users = ModelsUser::all();
        $data = array();
        foreach ($users as $user) {
            $data[] = array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            );
        }

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = null;
        $isReadonly = false;
        $urlAction = \route('user.store');
        $urlBack = \route('users');
        $pwd = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 12);

        return view('app.user.profile')
            ->with('isReadonly', $isReadonly)
            ->with('urlAction', $urlAction)
            ->with('urlBack', $urlBack)
            ->with('pwd', $pwd)
            ->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        try {
            $data = new ModelsUser();
            $data->name = $request['name'];
            $data->email = $request['email'];
            $data->password = Hash::make($request['password']);
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->route('user.show', $data->id)->with('success', "Succeed: User Added!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = ModelsUser::find($id);
        $isReadonly = true;
        $urlAction = '';

        return view('app.user.profile')
            ->with('isReadonly', $isReadonly)
            ->with('urlAction', $urlAction)
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = ModelsUser::find($id);
        $isReadonly = false;
        $urlAction = \route('user.update', $id);
        $urlBack = \route('user.show', $user->id);

        return view('app.user.profile')
            ->with('isReadonly', $isReadonly)
            ->with('urlAction', $urlAction)
            ->with('urlBack', $urlBack)
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        try {
            $data = ModelsUser::find($id);
            $data->name = $request['name'];
            $data->email = $request['email'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->route('user.show', $id)->with('success', "Succeed: Profile Updated!");
    }

    /**
     * Update the password in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'oldpassword' => ['required', 'string', 'min:8'],
        ]);

        try {
            $data = ModelsUser::find($id);
            if (Hash::check($request['oldpassword'], $data->password)) {
                $data->password = Hash::make($request['password']);
                $data->save();
            } else {
                return redirect()->back()->with('error', "Failed: Old Password is not match.");
            }
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->route('user.show', $id)->with('success', "Succeed: Password Changed!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
