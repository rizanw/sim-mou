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
            ModelsDocument::where('id', '=', $request['id'])->delete();
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
        ]);

        try {
            $name = preg_replace("/[^a-zA-Z0-9]+/", "", $request['number']) . "_" . time() . ".pdf";
            $path = $request->document->storeAs($this->folder, $name);

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
     * update Document data to the database application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        try {
            $data = ModelsDocument::find($request['id']);
            $data->save();
        } catch (Exception $exception) {
            $errorcode = $exception->getMessage();
            return redirect()->back()->with('error', "Failed: " . $errorcode);
        }

        return redirect()->back()->with('success', "Succeed: Document updated!");
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
}
