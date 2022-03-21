<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Continent as ModelsContinent;
use Exception;
use Illuminate\Http\Request;

class Continent extends Controller
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
     * Show the application continent dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('app.continents');
    }

    /**
     * Create json data for the application continent dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $continents = ModelsContinent::all();
        $data = array();
        foreach ($continents as $continent) {
            $data[] = array(
                'id' => $continent->id,
                'name' => $continent->name,
            );
        }

        return response()->json($data);
    }

    /**
     * store continent data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        try {
            $continent = new ModelsContinent;
            $continent->id = strtoupper($request['code']);
            $continent->name = $request['name'];
            $continent->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different continent code!");
            }
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: continent added!");
    }

    /**
     * update continent data to the database application
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
            $data = ModelsContinent::find($request['id']);
            $data->name = $request['name'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different continent code!");
            }
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: continent updated!");
    }

    /**
     * delete continent data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            ModelsContinent::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23503')) {
                return redirect()->back()->with('error', "Failed: you cannot delete continents who has (a) country(s)");
            }
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: continent deleted!");
    }
}
