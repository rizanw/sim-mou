<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Institution;
use Illuminate\Http\Request;

class PartnerChart extends Controller
{
    /**
     * Create json data based on partner, filtered by continent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function byContinent()
    {
        $data = array();
        $continents = Continent::all();

        foreach ($continents as $key => $continent) {
            $doc = Institution::with('country')
                ->whereRelation('country', 'continent_id', $continent->id)
                ->where('parent_id', null)
                ->where('is_partner', true)
                ->get();
            $data[] = array(
                $continent->name,
                $doc->count()
            );
        }

        return response()->json($data);
    }

    /**
     * Create json data based on partner, filtered by continent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function byCountry()
    {
        $data = array();
        $countries = Country::all();

        foreach ($countries as $key => $country) {
            $doc = Institution::where('country_id', $country->id)
                ->where('parent_id', null)
                ->where('is_partner', true)
                ->get();
            $data[] = array(
                'id' => $country->id,
                'name' => $country->name,
                'number' => $doc->count()
            );
        }

        usort($data, function($a, $b) {
            return $b['number'] <=> $a['number'];
        });
        $data = array_slice($data, 0, 10);

        return response()->json($data);
    }
}
