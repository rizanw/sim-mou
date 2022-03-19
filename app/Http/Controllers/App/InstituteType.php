<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\InstituteType as ModelsInstituteType;
use Exception;
use Illuminate\Http\Request;

class InstituteType extends Controller
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
     * Show the application InstituteType dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('app.instituteTypes');
    }

    /**
     * Create json data for the application InstituteType dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $instituteTypes = ModelsInstituteType::all();
        $data = array();
        foreach ($instituteTypes as $instituteType) {
            $data[] = array(
                'id' => $instituteType->id,
                'name' => $instituteType->name,
            );
        }

        return response()->json($data);
    }


    /**
     * store InstituteType data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $data = new ModelsInstituteType();
            $data->name = $request['name'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different InstituteType code!");
            }
        }

        return redirect()->back()->with('success', "Succeed: Institute Type added!");
    }

    /**
     * update InstituteType data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'id' => 'required',
        ]);

        try {
            $data = ModelsInstituteType::find($request['id']);
            $data->name = $request['name'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different Institute Type!");
            }
        }

        return redirect()->back()->with('success', "Succeed: Institute Type updated!");
    }

    /**
     * delete InstituteType data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            ModelsInstituteType::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23503')) {
                return redirect()->back()->with('error', "Failed: you cannot delete Institute Type who has (a) Institute(s)");
            }
        }

        return redirect()->back()->with('success', "Succeed: Institute Type deleted!");
    }
}
