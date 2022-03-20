<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Contact as ModelsContact;
use App\Models\Institution;
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
        $institutions = Institution::all();

        return view('app.contacts')
            ->with('institutions', $institutions);
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
            $name = $contact->nickname ? $contact->fullname . ' (' . $contact->nickname . ')' : $contact->fullname;
            $institutions = $contact->institutions;
            $institutionIds = array();
            $units = array();
            $institution = null;

            foreach ($institutions as $i) {
                if (!isset($i->parent_id)) {
                    $institution = $i;
                } else {
                    array_push($units, $i->name);
                }
                array_push($institutionIds, $i->id);
            }

            $data[] = array(
                'id' => $contact->id,
                'name' => $name,
                'fullname' => $contact->fullname,
                'nickname' => $contact->nickname,
                'telp' => json_decode($contact->telp),
                'email' => json_decode($contact->email),
                'institutions' => $institutionIds,
                'units' => $units,
                'institution' => $institution,
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
            'fullname' => 'required',
            'institutions' => 'required',
        ]);

        try {
            $data = new ModelsContact();
            $data->fullname = $request['fullname'];
            $data->nickname = $request['nickname'];
            $data->telp = json_encode($request['telp']);
            $data->email = json_encode($request['email']);
            $data->save();
            $data->institutions()->sync($request['institutions']);
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
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
            'fullname' => 'required',
            'institutions' => 'required',
        ]);

        try {
            $data = ModelsContact::find($request['id']);
            $data->fullname = $request['fullname'];
            $data->nickname = $request['nickname'];
            $data->telp = json_encode($request['telp']);
            $data->email = json_encode($request['email']);
            $data->institutions()->sync($request['institutions']);
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
            $contact = ModelsContact::find($request['id']);
            $contact->institutions()->detach($request['institutions']);
            $contact->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Contact deleted!");
    }
}
