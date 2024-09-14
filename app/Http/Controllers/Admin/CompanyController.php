<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Company\StoreCompanyRequest;
use App\Models\Company;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class CompanyController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Company::class);

        return view('admin.company.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', Company::class);

        return view('admin.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', Company::class);

        // Validate data
        $validated = $request->validated();

        // Upload logo if provided
        if ($request->hasFile('logo')) {
            $filename = time() . '.' . $request->file('logo')->extension();
            $validated['logo'] = $request->file('logo')->storeAs('companies/logos', $filename, 'public');
        }

        // Update record in database
        $company = Company::create($validated);


        session()->flash('success', 'Company created successfully!');

        return $this->saveAndRedirect($request, 'companies', $company->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        // Check Authorize
        Gate::authorize('view', $company);

        $audits = $company->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.company.show', [
            'company' => $company,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        // Check Authorize
        Gate::authorize('update', $company);

        return view('admin.company.edit', [
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCompanyRequest $request, Company $company)
    {
        // Check Authorize
        Gate::authorize('update', $company);

        // Validate data
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            // Remove old logo file
            if ($company->logo) {
                File::delete('storage/' . $company->logo);
            }
            // Upload new logo
            $filename = time() . '.' . $request->file('logo')->extension();
            $validated['logo'] = $request->file('logo')->storeAs('companies/logos', $filename, 'public');
        } else {
            // Unset logo key from validated array
            unset($validated['logo']);
        };

        // Update record in database
        $company->update($validated);

        // Flash message
        session()->flash('success', 'Company updated successfully!');

        return $this->saveAndRedirect($request, 'companies', $company->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('read', Company::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.company.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.companies.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('delete', Company::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.companies.index');
    }

    /**
     * Search Company
     */
    public function searchCompanies(Request $request)
    {
        $term = $request->input('term');
        $companies = Company::where('name', 'like', '%' . $term . '%')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'results' => $companies->map(function ($company) {
                return [
                    'id' => $company->id,
                    'text' => $company->name
                ];
            })
        ]);
    }
}
