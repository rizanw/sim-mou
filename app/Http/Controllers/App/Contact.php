<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Contact as ModelsContact;
use App\Models\Institute;
use Exception;
use Illuminate\Http\Request;

class Contact extends Controller
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
     * Show the application Contact dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $institutes = Institute::all();

        return view('app.contacts')
            ->with('institutes', $institutes);
    }

    /**
     * Create json data for the application Contact dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $contacts = ModelsContact::all();
        $data = array();
        foreach ($contacts as $contact) {
            if (isset($contact->institute_id)) {
                $contact->institute->country;
            }
            $name = $contact->nickname ? $contact->fullname . ' (' . $contact->nickname . ')' : $contact->fullname;
            $data[] = array(
                'id' => $contact->id,
                'type' => $contact->type,
                'name' => $name,
                'fullname' => $contact->fullname,
                'nickname' => $contact->nickname,
                'telp' => json_decode($contact->telp),
                'email' => json_decode($contact->email),
                'institute' => $contact->institute,
            );
        }

        return response()->json($data);
    }

    /**
     * store Contact data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'fullname' => 'required',
        ]);

        try {
            $data = new ModelsContact();
            $data->type = strtoupper($request['type']);
            $data->institute_id = $request['institute'];
            $data->fullname = $request['fullname'];
            $data->nickname = $request['nickname'];
            $data->telp = json_encode($request['telp']);
            $data->email = json_encode($request['email']);
            $data->save();
        } catch (Exception $exception) {
            dd($exception);
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different Contact code!");
            }
        }

        return redirect()->back()->with('success', "Succeed: Contact added!");
    }

    /**
     * update Contact data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'type' => 'required',
            'fullname' => 'required',
        ]);

        try {
            $data = ModelsContact::find($request['id']);
            $data->type = strtoupper($request['type']);
            $data->institute_id = $request['institute'];
            $data->fullname = $request['fullname'];
            $data->nickname = $request['nickname'];
            $data->telp = json_encode($request['telp']);
            $data->email = json_encode($request['email']);
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Contact updated!");
    }

    /**
     * delete Contact data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            ModelsContact::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Contact deleted!");
    }
}
