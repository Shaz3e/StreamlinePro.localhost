<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Exception;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $lead = new Lead();
            $lead->name = $request->name;
            $lead->company = $request->company;
            $lead->country = $request->country;
            $lead->email = $request->email;
            $lead->phone = $request->phone;
            $lead->product = $request->product;
            $lead->message = $request->message;

            $lead->save();

            return response()->json([
                'message' => 'We have received your information and will contact you shortly.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
