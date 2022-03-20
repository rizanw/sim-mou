<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use App\Models\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartnerUnit extends Controller
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
     * Show the application PartnerUnit dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $institution = Institution::where('id', $id)->first();
        $institutions = Institution::where('id', $id)->with('childInstitutions')->get();

        return view('app.partner.units')
            ->with('id', $id)
            ->with('institution', $institution)
            ->with('institutions',  $institutions);
    }

    /**
     * Create json data for the application PartnerUnit dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data($id)
    {
        $partners = Institution::where('id', $id)->with('childInstitutions')->get();
        $data = $this->getTree($partners[0]->childInstitutions);

        return response()->json($data);
    }

    /**
     * Create tree data for the application PartnerUnit dashboard.
     *
     * @return Array
     */
    private function getTree($arr)
    {
        $data = array();
        foreach ($arr as $partner) {
            $data[] = array(
                'id' => $partner->id,
                'name' => $partner->name,
                'parent_id' => $partner->parent_id,
                'website' => $partner->website,
                'telp' => $partner->telp,
                'email' => $partner->email,
                'label' => Str::title($partner->label),
                '_children' => $this->getTree($partner->childInstitutions)
            );
        }
        return $data;
    }

    /**
     * store PartnerUnit data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent' => 'required',
            'label' => 'required',
        ]);

        try {
            $data = new Institution();
            $data->name = $request['name'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->website = $request['website'];
            $data->is_partner = true;
            $data->label = $request['label'];
            $data->parent_id = $request['parent'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Institution Unit added! Add more contact person? <a href='" . \route('contacts') . "' class='link-success'>click here</a>");
    }

    /**
     * update PartnerUnit data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent' => 'required',
            'label' => 'required',
            'id' => 'required',
        ]);

        try {
            $data = Institution::find($request['id']);
            $data->name = $request['name'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->website = $request['website'];
            $data->label = $request['label'];
            $data->parent_id = $request['parent'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            if (strpos($errorcode, '23505')) {
                return redirect()->back()->with('error', "Failed: you can not insert a duplicate data, use different Institute Unit!");
            }
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Institution Unit updated!");
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
            Institution::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Institution Unit deleted!");
    }
}
