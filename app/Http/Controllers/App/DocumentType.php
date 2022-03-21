<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\DocumentType as ModelsDocumentType;
use Exception;
use Illuminate\Http\Request;

class DocumentType extends Controller
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
     * Show the application DocumentType dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('app.documentTypes');
    }

    /**
     * Create json data for the application DocumentType dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $documentTypes = ModelsDocumentType::all();
        $data = array();
        foreach ($documentTypes as $documentType) {
            $data[] = array(
                'id' => $documentType->id,
                'name' => $documentType->name,
                'shortname' => $documentType->shortname,
                'desc' => $documentType->desc,
            );
        }

        return response()->json($data);
    }


    /**
     * store DocumentType data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'shortname' => 'required',
        ]);

        try {
            $data = new ModelsDocumentType();
            $data->name = $request['name'];
            $data->shortname = $request['shortname'];
            $data->desc = $request['desc'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Document Type added!");
    }

    /**
     * update DocumentType data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'shortname' => 'required',
            'id' => 'required',
        ]);

        try {
            $data = ModelsDocumentType::find($request['id']);
            $data->name = $request['name'];
            $data->shortname = $request['shortname'];
            $data->desc = $request['desc'];
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Document Type updated!");
    }

    /**
     * delete DocumentType data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            ModelsDocumentType::where('id', '=', $request['id'])->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Document Type deleted!");
    }
}
