<?php

namespace App\Trait\Admin;

use Illuminate\Http\Request;

trait FormHelper
{
    public function saveAndRedirect(Request $request, $route, $id)
    {
        if ($request->has('save_and_view')) {
            return redirect()->route('admin.' . $route . '.show', $id);
        }else if($request->has('save_and_create_new')){
            return redirect()->route('admin.' . $route . '.create');
        }else{
            return redirect()->route('admin.' . $route . '.index');
        }
    }
}
