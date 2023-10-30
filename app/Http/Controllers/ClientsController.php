<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientsController extends Controller
{
    public function showRegistrationForm()
    {
        return view('home');
    }


    public function register(Request $request)
    {
        // Validate the form input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'nom_pere' => 'required|string|max:255',
            'prenom_pere' => 'required|string|max:255',
            'nom_mere' => 'required|string|max:255',
            'prenom_mere' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'province' => 'required|string|max:255',
            'commune' => 'required|string|max:255',
            'colline' => 'required|string|max:255',
            'residence_actuel' => 'required|string|max:255',
            'nationalite' => 'required|string|max:255',
            'religion' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^.+@.+$/'],
            'cni' => 'required|string|max:255',
            
            'checkpasseport' => 'required|in:non,oui',
            'passport' => 'nullable|required_if:checkpasseport,oui',
            
            'checkcartejaune' => 'required|in:non,oui',
            'checkpayerinscription' => 'required|in:non,oui',
            'checkpermisconduire' => 'required|in:non,oui',
            
            
            'enfant' => 'required|string|max:255',
            
            'marital_status' => 'required|in:single,married,divorce',
            'francais' => 'nullable',
            'anglais' => 'nullable',
            'kiswahili' => 'nullable',
            
            
            'niveau' => 'required|in:a2,licence,10e,9e',
            
            'nom_avaliseur' => 'required|string|max:255',
            'prenom_avaliseur' => 'required|string|max:255',
            'cni_avaliseur' => 'required|string|max:255',
            'telephone_avaliseur' => 'required|string|max:255',
            'province_avaliseur' => 'required|string|max:255',
            'commune_avaliseur' => 'required|string|max:255',
            'colline_avaliseur' => 'required|string|max:255',
            'lien_parente' => 'required|string|max:255',
             'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'diplome_client' => 'nullable|mimes:pdf|max:2048',
             'carteid_client' => 'nullable|mimes:pdf|max:2048',
             'att_ident_compl_client' => 'nullable|mimes:pdf|max:2048',
            ]);


                // Check if the email contains '@' symbol
                if (strpos($validatedData['email'], '@') === false) {
                    return response()->json(['error' => 'The email must contain the @ symbol.'], 422);
                }

            // Check if name and prenom already exist in the database
                $name = $validatedData['name'];
                $prenom = $validatedData['prenom'];
                $telephone = $validatedData['telephone'];
                $cni = $validatedData['cni'];
                
                $existingClient = Client::where('name', $name)
                    ->where('prenom', $prenom)
                    ->where('telephone', $telephone)
                    ->where('cni', $cni)
                    ->first();

                if ($existingClient) {
                    return response()->json(['error' => 'The client data already exist in the database.'], 422);
                }

        // Handle the checkbox values
        $francais = $request->has('francais') ? 1 : 0;
        $anglais = $request->has('anglais') ? 1 : 0;
        $kiswahili = $request->has('kiswahili') ? 1 : 0;

        // Handle the passport field
        $passport = $request->input('passport');
        $hasPassport = $request->input('checkpasseport') === 'oui';
        $hascartejaune = $request->input('checkcartejaune') === 'oui';
        $haspayerinscription = $request->input('checkpayerinscription') === 'oui';
        $haspermisconduire = $request->input('checkpermisconduire') === 'oui';
      
        if (!$hasPassport) {
            $passport = null;
        }
        

        // Handle the profile image upload
        $profileImage = null;
        if ($request->hasFile('profile_image')) {
            $uploadedFile = $request->file('profile_image');
            $profileImage = $uploadedFile->store('profile_images', 'public'); // You can modify the storage path as per your needs
        }


        // Handle the cv_client upload
        $diplome_client = null;
        if ($request->hasFile('diplome_client')) {
            $uploadedFile = $request->file('diplome_client');
            
            // Validate the file type
            if ($uploadedFile->getClientOriginalExtension() === 'pdf') {
                $diplome_client = $uploadedFile->store('diplome_client', 'public');
            } else {
                // Handle the case when the file is not a PDF
                // You can add appropriate error handling logic here
            }
        }




        // Handle the cv_client upload
        $carteid_client = null;
        if ($request->hasFile('carteid_client')) {
            $uploadedFile = $request->file('carteid_client');
            
            // Validate the file type
            if ($uploadedFile->getClientOriginalExtension() === 'pdf') {
                $carteid_client = $uploadedFile->store('carte_national_identite_client', 'public');
            } else {
                // Handle the case when the file is not a PDF
                // You can add appropriate error handling logic here
            }
        }



        // Handle the cv_client upload
        $att_ident_compl_client = null;
        if ($request->hasFile('att_ident_compl_client')) {
            $uploadedFile = $request->file('att_ident_compl_client');
            
            // Validate the file type
            if ($uploadedFile->getClientOriginalExtension() === 'pdf') {
                $att_ident_compl_client = $uploadedFile->store('attestation_identite_complete_client', 'public');
            } else {
                // Handle the case when the file is not a PDF
                // You can add appropriate error handling logic here
            }
        }



        // Create a new user record
        $client = new Client();

        $client->name = $validatedData['name'];
        $client->prenom = $validatedData['prenom'];
        $client->gender = $validatedData['gender'];
        $client->nom_pere = $validatedData['nom_pere'];
        $client->prenom_pere = $validatedData['prenom_pere'];
        $client->nom_mere = $validatedData['nom_mere'];
        $client->prenom_mere = $validatedData['prenom_mere'];
        $client->date_of_birth = $validatedData['date_of_birth'];
        $client->province = $validatedData['province'];
        $client->commune = $validatedData['commune'];
        $client->colline = $validatedData['colline'];
        $client->residence_actuel = $validatedData['residence_actuel'];
        
        $client->religion = $validatedData['religion'];
       
        $client->nationalite = $validatedData['nationalite'];
        $client->telephone = $validatedData['telephone'];
        $client->email = $validatedData['email'];
        $client->cni = $validatedData['cni'];


        $client->has_passport = $hasPassport;
        $client->passport = $passport;

        $client->has_cartejaune = $hascartejaune;
        $client->has_payerinscription = $haspayerinscription;
        $client->has_permisconduire = $haspermisconduire;

        $client->enfant = $validatedData['enfant'];

        $client->marital_status = $validatedData['marital_status'];
        $client->francais = $francais;
        $client->anglais = $anglais;
        $client->kiswahili = $kiswahili;
        $client->niveau = $validatedData['niveau'];

        $client->nom_avaliseur = $validatedData['nom_avaliseur'];
        $client->prenom_avaliseur = $validatedData['prenom_avaliseur'];
        $client->cni_avaliseur = $validatedData['cni_avaliseur'];
        $client->telephone_avaliseur = $validatedData['telephone_avaliseur'];
        $client->province_avaliseur = $validatedData['province_avaliseur'];
        $client->commune_avaliseur = $validatedData['commune_avaliseur'];
        
        $client->colline_avaliseur = $validatedData['colline_avaliseur'];
        $client->lien_parente = $validatedData['lien_parente'];

       $client->profile_image = $profileImage;
       $client->diplome_client = $diplome_client;
       $client->carteid_client = $carteid_client;
       $client->att_ident_compl_client = $att_ident_compl_client;

        $client->save();

        // Perform any additional actions or redirect as needed

        return response()->json(['success' => true]);
    }

}
