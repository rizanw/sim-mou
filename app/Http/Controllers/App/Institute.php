<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Institute as ModelsInstitute;
use App\Models\InstituteType;
use Exception;
use Illuminate\Http\Request;

class Institute extends Controller
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
     * Show the application Institute dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $instituteTypes = InstituteType::all();
        $continents = Continent::all();
        $countries = Country::all();

        return view('app.institution')
            ->with('instituteTypes', $instituteTypes)
            ->with('continents', $continents)
            ->with('countries', $countries);
    }


    /**
     * Create json data for the application Institute dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $institutes = ModelsInstitute::all();
        $data = array();
        foreach ($institutes as $institute) {
            $institute->country->continent;
            $data[] = array(
                'id' => $institute->id,
                'type' => $institute->instituteType,
                'name' => $institute->name,
                'website' => $institute->website,
                'telp' => $institute->telp,
                'email' => $institute->email,
                'address' => $institute->address,
                'country' => $institute->country,
            );
        }

        return response()->json($data);
    }


    /**
     * store Institute data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'institute_type' => 'required',
            'country_id' => 'required',
        ]);

        try {
            $data = new ModelsInstitute();
            $data->name = $request['name'];
            $data->address = $request['address'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->website = $request['website'];
            $data->institute_type_id = $request['institute_type'];
            $data->country_id = $request['country_id'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different Institute code!");
            }
        }

        return redirect()->back()->with('success', "Succeed: Institute added! Add more contact person? <a href='" . \route('contacts') . "' class='link-success'>click here</a>");
    }

    /**
     * update Institute data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'institute_type' => 'required',
            'country_id' => 'required',
        ]);

        try {
            $data = ModelsInstitute::find($request['id']);
            $data->name = $request['name'];
            $data->address = $request['address'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->website = $request['website'];
            $data->institute_type_id = $request['institute_type'];
            $data->country_id = $request['country_id'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different Institute!");
            }
        }

        return redirect()->back()->with('success', "Succeed: Institute updated!");
    }

    /**
     * delete Institute data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            ModelsInstitute::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23503')) {
                return redirect()->back()->with('error', "Failed: you cannot delete Institute who has (a) Unit(s)");
            }
        }

        return redirect()->back()->with('success', "Succeed: Institute deleted!");
    }
}
