<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InternalUnit extends Controller
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
     * Show the application Internal Unit dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $institutions = Institution::where([
            ['is_partner', false],
            ['parent_id', null]
        ])->with('childInstitutions')->get();

        return view('app.internalUnit')
            ->with("institutions", $institutions);
    }


    /**
     * Create json data for the application Internal Unit dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $institution = Institution::where([['is_partner', false], ['parent_id', null]])->first();
        $data = $this->getTree($institution->childInstitutions);

        return response()->json($data);
    }

    /**
     * Create tree data for the application Internal Unit dashboard.
     *
     * @param Array
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
     * store Internal Unit data to the database application
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
            $parent = Institution::where([['is_partner', false], ['parent_id', null]])->first();

            $data = new Institution();
            $data->name = $request['name'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->website = $request['website'];
            $data->label = $request['label'];
            $data->is_partner = false;
            $data->parent_id = $request['parent'];

            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Internal Unit added!");
    }

    /**
     * update Internal Unit data to the database application
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

        return redirect()->back()->with('success', "Succeed: Internal Unit updated!");
    }

    /**
     * delete Internal Unit data from the database application
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

        return redirect()->back()->with('success', "Succeed: Internal Unit deleted!");
    }
}
