<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Program as ModelsProgram;
use Exception;
use Illuminate\Http\Request;

class Program extends Controller
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
     * Show the application Program dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('app.programs');
    }


    /**
     * Create json data for the application Program dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $programs = ModelsProgram::all();
        $data = array();
        foreach ($programs as $program) {
            $data[] = array(
                'id' => $program->id,
                'name' => $program->name,
                'desc' => $program->desc,
            );
        }

        return response()->json($data);
    }


    /**
     * store Program data to the database application
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
            $data = new ModelsProgram();
            $data->name = $request['name'];
            $data->desc = $request['desc'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Program added!");
    }

    /**
     * update Program data to the database application
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
            $data = ModelsProgram::find($request['id']);
            $data->name = $request['name'];
            $data->desc = $request['desc'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Program updated!");
    }

    /**
     * delete Program data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            ModelsProgram::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Program deleted!");
    }
}
