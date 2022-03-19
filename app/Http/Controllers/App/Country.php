<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use App\Models\Country as ModelsCountry;
use Exception;
use Illuminate\Http\Request;

class Country extends Controller
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
     * Show the application country dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $continents = Continent::all();

        return view('app.countries')
            ->with("continents", $continents);
    }

    /**
     * Create json data for the application country dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $countries = ModelsCountry::all();
        $data = array();
        foreach ($countries as $country) {
            $data[] = array(
                'id' => $country->id,
                'name' => $country->name,
                'continent' => $country->continent,
            );
        }

        return response()->json($data);
    }


    /**
     * store country data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'continent_id' => 'required',
        ]);

        try {
            $data = new ModelsCountry();
            $data->id = strtoupper($request['code']);
            $data->name = $request['name'];
            $data->continent_id = $request['continent_id'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different country code!");
            }
        }

        return redirect()->back()->with('success', "Succeed: country added!");
    }

    /**
     * update country data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'id' => 'required',
            'continent_id' => 'required',
        ]);

        try {
            $data = ModelsCountry::find($request['id']);
            $data->name = $request['name'];
            $data->continent_id = $request['continent_id'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different country code!");
            }
        }

        return redirect()->back()->with('success', "Succeed: country updated!");
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
            ModelsCountry::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23503')) {
                return redirect()->back()->with('error', "Failed: you cannot delete continents who has (a) country(s)");
            }
        }

        return redirect()->back()->with('success', "Succeed: country deleted!");
    }
}
