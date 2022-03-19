<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use App\Models\InstituteUnit as ModelsInstituteUnit;
use Exception;
use Illuminate\Http\Request;

class InstituteUnit extends Controller
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
     * Show the application InstituteUnit dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $institutions = Institute::all();

        return view('app.units')
            ->with('institutions', $institutions);
    }

    /**
     * Create json data for the application InstituteUnit dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $units = ModelsInstituteUnit::all();
        $data = array();
        foreach ($units as $unit) {
            $data[] = array(
                'id' => $unit->id,
                'name' => $unit->name,
                'desc' => $unit->desc,
                'institute' => $unit->institute,
            );
        }

        return response()->json($data);
    }

    /**
     * store InstituteUnit data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'institute' => 'required',
        ]);

        try {
            $data = new ModelsInstituteUnit();
            $data->name = $request['name'];
            $data->institute_id = $request['institute'];
            $data->desc = $request['desc'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different Unit code!");
            }
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Unit added!");
    }

    /**
     * update InstituteUnit data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'institute' => 'required',
        ]);

        try {
            $data = ModelsInstituteUnit::find($request['id']);
            $data->name = $request['name'];
            $data->institute_id = $request['institute'];
            $data->desc = $request['desc'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different Institute Unit!");
            }
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Unit updated!");
    }

    /**
     * delete InstituteUnit data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            ModelsInstituteUnit::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Unit deleted!");
    }
}
