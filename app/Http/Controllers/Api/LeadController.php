<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lead;
use App\Mail\NewContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request){
        $form_data = $request->all();

        // Validation for the parameters in the api
        $validator = Validator::make($form_data, [
            'email' => 'required|max:50',
            'name' => 'required|max:50',
            'content' => 'required| max:60000'
        ]);

        // If the validation fails, it return the errors
        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $new_lead = new Lead();
        $new_lead->fill($form_data);
        $new_lead->save();
        
        Mail::to('customer@email.it')->send(new NewContactMail($new_lead));

        return response()->json([
            'success' => true
        ]);

    }
}
