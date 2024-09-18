<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DownlaodController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user

        // Retrieve the downloads for the user through the downloads() relationship
        // $downloads = $user->downloads()->get();
        // get user's active download
        $downloads = $user->downloads()->where('is_active', true)->get();

        return view('user.download.index', [
            'downloads' => $downloads,
        ]);
    }

    public function show(string $id)
    {
        $user = Auth::user(); // Get the authenticated user
        $download = $user->downloads()->where([
            'downloads.id' => $id,
            'is_active' => true
        ])->first();

        if (!$download) {
            session()->flash('error', 'This download does not exits or removed');
            return to_route('downloads.index');
        }

        return view('user.download.show', [
            'download' => $download
        ]);
    }
}
