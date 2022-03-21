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
        return view('app.institutionTypes');
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
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Institution Type added!");
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
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Institution Type updated!");
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
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Institution Type deleted!");
    }
}
