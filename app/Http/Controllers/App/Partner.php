<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Institution;
use App\Models\InstitutionType;
use Exception;
use Illuminate\Http\Request;

class Partner extends Controller
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
     * Show the application Partner dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $institutionTypes = InstitutionType::all();
        $continents = Continent::all();
        $countries = Country::all();

        return view('app.partner.institutions')
            ->with('institutionTypes', $institutionTypes)
            ->with('continents', $continents)
            ->with('countries', $countries);
    }

    /**
     * Create json data for the application Partner dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $institutions = Institution::all();
        $data = array();
        foreach ($institutions as $institution) {
            if ($institution->is_partner && !isset($institution->parent_id)) {
                $institution->country->continent;
                $data[] = array(
                    'id' => $institution->id,
                    'type' => $institution->institutionType,
                    'name' => $institution->name,
                    'website' => $institution->website,
                    'telp' => $institution->telp,
                    'email' => $institution->email,
                    'address' => $institution->address,
                    'country' => $institution->country,
                );
            }
        }

        return response()->json($data);
    }


    /**
     * store Partner data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'institution_type' => 'required',
            'country_id' => 'required',
        ]);

        try {
            $data = new Institution();
            $data->name = $request['name'];
            $data->address = $request['address'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->website = $request['website'];
            $data->institution_type_id = $request['institution_type'];
            $data->country_id = $request['country_id'];
            $data->is_partner = true;
            $data->label = "INSTITUTION";
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Institution added! Add more contact person? <a href='" . \route('contacts') . "' class='link-success'>click here</a>");
    }


    /**
     * update Partner data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'institution_type' => 'required',
            'country_id' => 'required',
        ]);

        try {
            $data = Institution::find($request['id']);
            $data->name = $request['name'];
            $data->address = $request['address'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->website = $request['website'];
            $data->institution_type_id = $request['institution_type'];
            $data->country_id = $request['country_id'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Institution updated!");
    }

    /**
     * delete Partner data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            Institution::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23503')) {
                return redirect()->back()->with('error', "Failed: you cannot delete Institution who has (a) Unit(s)");
            }
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Institution deleted!");
    }
}
