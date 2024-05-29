<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Currency\StoreCurrencyRequest;
use App\Models\Currency;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CurrencyController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Currency::class);

        return redirect()->route('admin.settings.currency');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', Currency::class);

        return view('admin.currency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurrencyRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', Currency::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $currency = Currency::create($validated);


        session()->flash('success', 'Currency created successfully!');

        return $this->saveAndRedirect($request, 'settings.currencies', $currency->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        // Check Authorize
        Gate::authorize('view', $currency);

        if ($currency) {
            return redirect()->route('admin.settings.currencies.edit', $currency->id);
        } else {
            return redirect()->route('admin.settings.currency');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        // Check Authorize
        Gate::authorize('update', $currency);

        if(!$currency){
            return redirect()->route('admin.settings.currency');
        }

        return view('admin.currency.edit', [
            'currency' => $currency,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCurrencyRequest $request, Currency $currency)
    {
        // Check Authorize
        Gate::authorize('update', $currency);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $currency->update($validated);

        // Flash message
        session()->flash('success', 'Currency updated successfully!');

        return $this->saveAndRedirect($request, 'settings.currencies', $currency->id);
    }

    /**
     * Search Company
     */
    public function searchCurrencies(Request $request)
    {
        // Check Authorize
        // Gate::authorize('create', Company::class);

        $term = $request->input('term');
        $currencies = Currency::where('name', 'like', '%' . $term . '%')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'results' => $currencies->map(function ($currency) {
                return [
                    'id' => $currency->id,
                    'text' => $currency->name
                ];
            })
        ]);
    }
}
