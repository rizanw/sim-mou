<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\InstitutionType as ModelsInstitutionType;
use Exception;
use Illuminate\Http\Request;

class InstitutionType extends Controller
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
     * Show the application InstitutionType dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('app.InstitutionTypes');
    }

    /**
     * Create json data for the application InstitutionType dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $institutionTypes = ModelsInstitutionType::all();
        $data = array();
        foreach ($institutionTypes as $institutionType) {
            $data[] = array(
                'id' => $institutionType->id,
                'name' => $institutionType->name,
            );
        }

        return response()->json($data);
    }


    /**
     * store InstitutionType data to the database application
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
            $data = new ModelsInstitutionType();
            $data->name = $request['name'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different InstitutionType code!");
            }
        }

        return redirect()->back()->with('success', "Succeed: Institute Type added!");
    }

    /**
     * update InstitutionType data to the database application
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
            $data = ModelsInstitutionType::find($request['id']);
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
     * delete InstitutionType data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            ModelsInstitutionType::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23503')) {
                return redirect()->back()->with('error', "Failed: you cannot delete Institute Type who has (a) Institute(s)");
            }
        }

        return redirect()->back()->with('success', "Succeed: Institute Type deleted!");
    }
}
