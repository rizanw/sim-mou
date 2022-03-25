<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Institution;
use Exception;
use Illuminate\Http\Request;

class Internal extends Controller
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
     * Show the application internal dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $institution = Institution::where([['is_partner', false], ['parent_id', null]])->first();

        return view('app.internal')
            ->with("institution", $institution);
    }

    /**
     * Show the application internal editor.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editView()
    {
        $institution = Institution::where([
            ['is_partner', false],
            ['parent_id', null],
        ])->first();
        $countries = Country::all();
        $isEdit = true;

        return view('app.internal')
            ->with("isEdit", $isEdit)
            ->with("countries", $countries)
            ->with("institution", $institution);
    }

    /**
     * update Internal Institution data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
        ]);

        try {
            $data = Institution::where([['is_partner', false], ['parent_id', null]])->first();
            $data->name = $request['name'];
            $data->address = $request['address'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->website = $request['website'];
            $data->country_id = $request['country'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->route('internal.institution')->with('success', "Succeed: Institution updated!");
    }
}
