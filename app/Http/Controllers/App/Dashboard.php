<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class Dashboard extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $docTypes = DocumentType::all();
        $docNumberByType = array();
        foreach ($docTypes as $key => $docType) {
            $num = $this->countDocumentByType($docType->id);
            $docNumberByType[] =  array(
                'id' => $docType->id,
                'name' => $docType->name,
                'shortname' => $docType->shortname,
                'number' => $num,
            );
        }

        return view('app.dashboard')
            ->with('docNumberByType', $docNumberByType);
    }

    /**
     * count Documents by document type
     *
     * @param Int $id
     * @return Int 
     */
    public function countDocumentByType($id)
    {
        $docs = Document::where('document_type_id', $id)->get();
        return count($docs);
    }
}
