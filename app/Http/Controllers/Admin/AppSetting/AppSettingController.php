<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppSetting\AppSettingRequest;
use App\Models\AppSetting;
use App\Trait\Admin\FormHelper;
use Illuminate\Support\Facades\Gate;

class AppSettingController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', AppSetting::class);

        $appSettings = AppSetting::paginate(20);
        
        return view('admin.app-setting.crud.index', [
            'appSettings' => $appSettings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', AppSetting::class);
        
        return view('admin.app-setting.crud.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppSettingRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', AppSetting::class);

        $validated = $request->validated();

        $appsetting = AppSetting::create($validated);

        session()->flash('success', 'New setting has been added');

        return $this->saveAndRedirect($request, 'app-settings', $appsetting->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(AppSetting $appSetting)
    {
        // Check Authorize
        Gate::authorize('view', $appSetting);

        return redirect()->route('admin.app-settings.edit', $appSetting->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppSetting $appSetting)
    {
        // Check Authorize
        Gate::authorize('update', $appSetting);

        return view('admin.app-setting.crud.edit', [
            'appSetting' => $appSetting,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppSettingRequest $request, AppSetting $appSetting)
    {
        // Check Authorize
        Gate::authorize('update', $appSetting);

        $validated = $request->validated();

        $appSetting->update($validated);

        session()->flash('success', 'App setting has been updated');

        return $this->saveAndRedirect($request, 'app-settings', $appSetting->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppSetting $appSetting)
    {
        // Check Authorize
        Gate::authorize('delete', $appSetting);

        return redirect()->route('admin.app-settings.index');
    }
}
