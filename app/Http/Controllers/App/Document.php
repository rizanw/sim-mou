<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Document as ModelsDocument;
use App\Models\DocumentType;
use App\Models\Institution;
use App\Models\Program;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Document extends Controller
{
    // const
    public $documentStatusActive = "Active";
    public $documentStatusInactive = "Inactive";
    public $documentStatusInRenewal = "In Renewal";
    public $documentStatusExpired = "Expired";
    private $folder = "documents";

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
     * Show the application Document dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('app.document.index');
    }

    /**
     * Create json data for the application Document dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $documents = ModelsDocument::all();
        $data = array();
        foreach ($documents as $document) {
            $partners = array();
            if (isset($document->institutions)) {
                foreach ($document->institutions as $key => $value) {
                    if ($value->is_partner && !isset($value->parent_id)) {
                        array_push($partners, $value->name);
                    }
                }
            }

            $data[] = array(
                'id' => $document->id,
                'title' => $document->title,
                'number' => $document->number,
                'status' => $document->status,
                'type' => $document->documentType,
                'partners' => $partners,
                'desc' => $document->desc,
                'startDate' => $document->start_date,
                'endDate' => $document->end_date,

            );
        }

        return response()->json($data);
    }

    /**
     * delete Document data from the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            $data = ModelsDocument::find($request['id']);
            $data->programs()->detach();
            $data->institutions()->detach();
            $data->delete();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Document deleted!");
    }

    /**
     * Show the application Document creator.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createView()
    {
        $statuses = array(
            $this->documentStatusActive,
            $this->documentStatusInactive,
            $this->documentStatusInRenewal,
            $this->documentStatusExpired
        );
        $documentTypes = DocumentType::all();
        $programs = Program::all();
        $institutions = Institution::where('parent_id', null)->get();
        $partners = Institution::where([['is_partner', true], ['parent_id', null]])->get();
        $url = \route('document.store');

        return view('app.document.editor')
            ->with('pageTitle', 'Create Document')
            ->with('url', $url)
            ->with('institutions', $institutions)
            ->with('partners', $partners)
            ->with('programs', $programs)
            ->with('documentTypes', $documentTypes)
            ->with('statuses', $statuses);
    }

    /**
     * store Document data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'document-type' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'number' => 'required',
            'title' => 'required',
            'file' => 'required',
        ]);

        try {
            $name = preg_replace("/[^a-zA-Z0-9]+/", "", $request['number']) . "_" . time() . ".pdf";
            $request->document->storeAs($this->folder, $name);

            $data = new ModelsDocument();
            $data->status = $request['status'];
            $data->start_date = $request['startdate'];
            $data->end_date = $request['enddate'];
            $data->document_type_id = $request['document-type'];
            $data->number = $request['number'];
            $data->title = $request['title'];
            $data->desc = $request['desc'];
            $data->file = $name;
            $data->save();

            $data->programs()->sync($request['programs']);
            foreach ($request['institution'] as $key => $val) {
                $data->institutions()->attach($val, ['party' => $key]);
                if (isset($request['units'][$key])) {
                    $data->institutions()->attach($request['units'][$key], ['party' => $key]);
                }
            }
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Document added!");
    }


    /**
     * Show the application Document editor.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editView($id)
    {
        $statuses = array(
            $this->documentStatusActive,
            $this->documentStatusInactive,
            $this->documentStatusInRenewal,
            $this->documentStatusExpired
        );
        $documentTypes = DocumentType::all();
        $programs = Program::all();
        $institutions = Institution::where('parent_id', null)->get();
        $partners = Institution::where([['is_partner', true], ['parent_id', null]])->get();
        $url = \route('document.update');

        $document = ModelsDocument::where('id', $id)->first();
        $startdate = explode("-", $document->start_date);
        $document->start_date = $startdate[1] . "/" . $startdate[2] . "/" . $startdate[0];
        $enddate = explode("-", $document->end_date);
        $document->end_date = $enddate[1] . "/" . $enddate[2] . "/" . $enddate[0];

        $docPrograms = array();
        foreach ($document->programs as $val) {
            array_push($docPrograms, $val->id);
        }

        $docUnits = array();
        $docInstituions = array();
        $insti = $document->institutions()->orderBy('party')->get();
        foreach ($insti as $val) {
            if (isset($val->parent_id)) {
                $docUnits[] = array(array($val->pivot->party), array($val->id));
            } else {
                $docInstituions[] = array($val->pivot->party => $val->id);
            }
        }

        return view('app.document.editor')
            ->with('pageTitle', 'Edit Document')
            ->with('url', $url)
            ->with('document', $document)
            ->with('docPrograms', $docPrograms)
            ->with('docUnits', $docUnits)
            ->with('docInstituions', $docInstituions)
            ->with('institutions', $institutions)
            ->with('partners', $partners)
            ->with('programs', $programs)
            ->with('documentTypes', $documentTypes)
            ->with('statuses', $statuses);
    }

    /**
     * update Document data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required',
            'document-type' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'number' => 'required',
            'title' => 'required',
        ]);

        try {
            $data = ModelsDocument::find($request['id']);
            $data->status = $request['status'];
            $data->start_date = $request['startdate'];
            $data->end_date = $request['enddate'];
            $data->document_type_id = $request['document-type'];
            $data->number = $request['number'];
            $data->title = $request['title'];
            $data->desc = $request['desc'];

            if (isset($request->document)) {
                $name = preg_replace("/[^a-zA-Z0-9]+/", "", $request['number']) . "_" . time() . ".pdf";
                $request->document->storeAs($this->folder, $name);
                $data->file = $name;
            }

            $data->save();

            $data->institutions()->detach();
            $data->programs()->sync($request['programs']);

            if (isset($request['institution']) || isset($request['units'])) {
                $data->institutions()->detach();
                if (isset($request['institution'])) {
                    foreach ($request['institution'] as $key => $val) {
                        $data->institutions()->attach($val, ['party' => $key]);
                    }
                }
                if (isset($request['units'])) {
                    foreach ($request['units'] as $key => $val) {
                        $data->institutions()->attach($val, ['party' => $key]);
                    }
                }
            }
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Document updated!");
    }

    /**
     * Show the detail of Document.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detailView($id)
    {
        $statuses = array(
            $this->documentStatusActive,
            $this->documentStatusInactive,
            $this->documentStatusInRenewal,
            $this->documentStatusExpired
        );
        $documentTypes = DocumentType::all();
        $programs = Program::all();
        $institutions = Institution::where('parent_id', null)->get();
        $partners = Institution::where([['is_partner', true], ['parent_id', null]])->get();
        $url = \route('document.update');

        $document = ModelsDocument::where('id', $id)->first();
        $startdate = explode("-", $document->start_date);
        $document->start_date = $startdate[1] . "/" . $startdate[2] . "/" . $startdate[0];
        $enddate = explode("-", $document->end_date);
        $document->end_date = $enddate[1] . "/" . $enddate[2] . "/" . $enddate[0];

        $docPrograms = array();
        foreach ($document->programs as $val) {
            array_push($docPrograms, $val->id);
        }

        $docUnits = array();
        $docInstituions = array();
        $insti = $document->institutions()->orderBy('party')->get();
        foreach ($insti as $val) {
            if (isset($val->parent_id)) {
                $docUnits[] = array(array($val->pivot->party), array($val));
            } else {
                $docInstituions[] = array($val->pivot->party => $val->id);
            }
        }

        $isReadonly = true;
        $predecessors = ModelsDocument::where('id', $id)->with('childs')->get();
        $countTree = $this->countTree($predecessors[0]->childs, 0);

        return view('app.document.editor')
            ->with('pageTitle', 'Document ' . $document->number)
            ->with('id', $id)
            ->with('url', $url)
            ->with('isReadonly', $isReadonly)
            ->with('document', $document)
            ->with('countTree', $countTree)
            ->with('docPrograms', $docPrograms)
            ->with('docUnits', $docUnits)
            ->with('docInstituions', $docInstituions)
            ->with('institutions', $institutions)
            ->with('partners', $partners)
            ->with('programs', $programs)
            ->with('documentTypes', $documentTypes)
            ->with('statuses', $statuses);
    }

    /**
     * download Documents data from database application
     * @param Int $id 
     * @return String
     */
    public function download($id)
    {
        $data = ModelsDocument::where('id', $id)->first();
        if (isset($data->file)) {
            $filepath = $this->folder . '/' . $data->file;
            $file = Storage::get($filepath);
            $response = Response::make($file, 200);
            $response->header('Content-Type', 'application/pdf');
        } else {
            $response = Response::make("", 404);
        }

        return $response;
    }

    /**
     * Create json data for the application Predecessor Document dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function predecessorData($id)
    {
        $documents = ModelsDocument::where('id', $id)->with('childs')->get();
        $data = $this->getTree($documents[0]->childs);

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
        foreach ($arr as $document) {
            $partners = array();
            if (isset($document->institutions)) {
                foreach ($document->institutions as $key => $value) {
                    if ($value->is_partner && !isset($value->parent_id)) {
                        array_push($partners, $value->name);
                    }
                }
            }

            $data[] = array(
                'id' => $document->id,
                'title' => $document->title,
                'number' => $document->number,
                'status' => $document->status,
                'type' => $document->documentType,
                'partners' => $partners,
                'desc' => $document->desc,
                'startDate' => $document->start_date,
                'endDate' => $document->end_date,
                '_children' => $this->getTree($document->childs)
            );
        }
        return $data;
    }

    private function countTree($arr, $counter)
    {
        foreach ($arr as $document) {
            if($document->childs){
                return $this->countTree($document->childs, $counter + 1);
            }
        }
        return $counter;
    }
}
