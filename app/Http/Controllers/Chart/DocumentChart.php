<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentChart extends Controller
{
    /**
     * Create json data based on document, filtered by continents.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function byContinent()
    {
        $data = array();
        $continents = Continent::all();

        foreach ($continents as $key => $continent) {
            $doc = Document::with('institutions.country')->whereRelation('institutions.country', 'continent_id', $continent->id)->get();
            $data[] = array(
                $continent->name,
                $doc->count()
            );
        }

        return response()->json($data);
    }
}
