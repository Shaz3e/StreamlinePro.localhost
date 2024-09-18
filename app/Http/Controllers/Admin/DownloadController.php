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

        // Forget uploadFile Session
        session()->forget('uploadFile');

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

        // Retrieve the file path from the session
        $uploadFile = session()->get('uploadFile');

        // If file was uploaded and exists in session
        if (!empty($uploadFile)) {
            // Store only the first file (since it's a single file upload)
            $validated['file_path'] = $uploadFile[0]; // No need for json_encode since it's a single file
        }

        // Update record in database
        $download = Download::create($validated);

        // Clear the session variable to avoid duplication
        session()->forget('uploadFile');

        if ($request->has('user_id')) {
            $download->users()->attach($validated['user_id']);
        }

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

        // Retrieve the file path from the session
        $uploadFile = session()->get('uploadFile');

        // If file was uploaded and exists in session
        if (!empty($uploadFile)) {
            // Delete previous download
            if ($download->file_path) {
                File::delete('storage/' . $download->file_path);
            }
            // Store only the first file (since it's a single file upload)
            $validated['file_path'] = $uploadFile[0]; // No need for json_encode since it's a single file
        }

        // Update record in database
        $download = Download::create($validated);

        // Clear the session variable to avoid duplication
        session()->forget('uploadFile');

        // Update record in database
        $download->update($validated);

        $download->users()->sync($validated['user_id']);

        session()->flash('success', 'Download updated successfully!');

        return $this->saveAndRedirect($request, 'downloads', $download->id);
    }

    public function uploadFile(Request $request)
    {
        // Validate file
        $request->validate([
            'file_path' => 'required|file|mimes:zip,exe,msi|max:102400',
        ]);

        // Get the uploaded image
        $download = $request->file('file_path');

        // File Name
        $filename = rand(1, 9999) . '-' . time() . '.' . $download->extension();

        // Store the uploaded file in the 'downloads' directory within 'public' disk
        $filePath = $download->storeAs('downloads', $filename, 'public');

        // Store the file path in session (optional)
        session()->push('uploadFile', $filePath);

        return response()->json(['message' => 'File uploaded successfully!']);
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
