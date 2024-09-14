<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Search Country
     */
    public function searchCountries(Request $request)
    {
        $term = $request->input('term');
        $countries = Country::where('name', 'like', '%' . $term . '%')
            ->orWhere('alpha2', 'like', '%' . $term . '%')
            ->orWhere('alpha3', 'like', '%' . $term . '%')
            ->orWhere('calling_code', 'like', '%' . $term . '%')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'results' => $countries->map(function ($country) {
                return [
                    'id' => $country->id,
                    'text' => $country->name
                ];
            })
        ]);
    }
}
