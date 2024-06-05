<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CountryController extends Controller
{
    /**
     * Search Country
     */
    public function searchCountries(Request $request)
    {
        // Check Authorize
        // Gate::authorize('create', Country::class);

        $term = $request->input('term');
        $countries = Country::where('name', 'like', '%' . $term . '%')
            ->orWhere('alpha2', 'like', '%' . $term . '%')
            ->orWhere('alpha3', 'like', '%' . $term . '%')
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
