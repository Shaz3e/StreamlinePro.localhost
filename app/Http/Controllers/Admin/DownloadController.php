<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Download\StoreDownloadRequest;
use App\Models\Download;
use App\Models\User;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;


class DownloadController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Download::class);

        return view('admin.download.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', Download::class);

        $users = User::all();

        return view('admin.download.create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDownloadRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', Download::class);

        // Validate data
        $validated = $request->validated();

        // Upload logo if provided
        if ($request->hasFile('file_path')) {
            $filename = time() . '.' . $request->file('file_path')->extension();
            $validated['file_path'] = $request->file('file_path')->storeAs('downloads', $filename, 'public');
        }

        // Update record in database
        $download = Download::create($validated);

        $download->users()->attach($validated['user_id']);

        session()->flash('success', 'Download created successfully!');

        return $this->saveAndRedirect($request, 'downloads', $download->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Download $download)
    {
        // Check Authorize
        Gate::authorize('read', $download);

        $users = User::all();

        // Retrieve the IDs of the users already assigned to the download
        $downloadUser = $download->users->pluck('id')->toArray();

        return view('admin.download.show', [
            'download' => $download,
            'users' => $users,
            'downloadUser' => $downloadUser,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Download $download)
    {
        // Check Authorize
        Gate::authorize('update', $download);

        $users = User::all();

        // Retrieve the IDs of the users already assigned to the download
        $downloadUser = $download->users->pluck('id')->toArray();

        return view('admin.download.edit', [
            'download' => $download,
            'users' => $users,
            'downloadUser' => $downloadUser
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDownloadRequest $request, Download $download)
    {
        // Check Authorize
        Gate::authorize('update', $download);

        // Validate data
        $validated = $request->validated();

        // Upload logo if provided
        if ($request->hasFile('file_path')) {
            // Delete previous download
            if ($download->file_path) {
                File::delete('storage/' . $download->file_path);
            }
            $filename = time() . '.' . $request->file('file_path')->extension();
            $validated['file_path'] = $request->file('file_path')->storeAs('downloads', $filename, 'public');
        }

        // Update record in database
        $download->update($validated);

        $download->users()->sync($validated['user_id']);

        session()->flash('success', 'Download updated successfully!');

        return $this->saveAndRedirect($request, 'downloads', $download->id);
    }

    /**
     * Search Departments
     */
    public function searchDownloads(Request $request)
    {
        $term = $request->input('term');
        $downloads = Download::where('name', 'like', '%' . $term . '%')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'results' => $downloads->map(function ($download) {
                return [
                    'id' => $download->id,
                    'text' => $download->title
                ];
            })
        ]);
    }
}
