<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Mail\NewContact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store(Request $request){
        // recuperiamo i dati inviati dalla form
        $data = $request->all();
        //  creiamo le regole di validazione
        $validator = Validator::make($data, [
           'name' => ['required', 'max:100'],
           'surname' => ['required', 'max:100'],
           'phone' => ['required', 'max:20'],
           'email' => ['required', 'max:120'],
           'content' => ['required'],
        ],
        $errors = [
              'name.required' => 'il nome è obbligatorio',
              'surname.required' => 'il cognome è obbligatorio',
              'phone.required' => 'il numero di telefono è obbligatorio',
              'email.required' => 'email deve essere  obbligatoria',
              'content.required' => 'il contenuto è obbligatorio',
              'name.max' => 'il nome deve essere lungo al massimo 50 caratteri',
              'surname.max' => 'il cognome deve essere lungo al massimo :max caratteri',
              'phone.max' => 'il numero di telefono deve essere lungo al massimo :max caratteri',
              'email.max' => 'email deve essere lungo al massimo :max caratteri',
        ]);
        //   verifico che non ci siano errori nella form
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
    //    se tutto va bene creo un nuovo record lead
       $new_lead = new Lead();
       $new_lead->fill($data);
       $new_lead->save();

       // devo inviare la email
        Mail::to('Info@boolfolio.it')->send(new NewContact($new_lead));
        return response()->json([
            'success' => true,
        ]);
    }
}
