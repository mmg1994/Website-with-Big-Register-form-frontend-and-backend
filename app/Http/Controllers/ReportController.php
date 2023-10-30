<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\sended;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use URL;





use Illuminate\Support\Facades\Http;


use App\Models\Client;
use App\Models\Saved;
use App\Models\User;
use App\Http\Controllers\Controller;

use App\Models\getInvoice;
use App\Models\getClients;

use App\Models\getdetails_facture;



use DataTables;
use Carbon\Carbon;
use PDF;



use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;





class ReportController extends Controller
{
    // report

/*
    public function report(Request $request)
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

        $fromdate = $request->fromdate;
        $todate   = $request->todate;
        $name     = $request->name;


      //  $data = \DB::select("SELECT * FROM personals WHERE created_at BETWEEN '$fromdate 00:00:00'AND'$todate 23:59:59'");
//orderBy('id', 'desc')->take(5)->get();
        $data = DB::table('CLIENTS')
        ->join('ENTETE_FACTURE', 'CLIENTS.CT_Num' , '=', 'ENTETE_FACTURE.DO_Tiers')
       // ->join('DETAILS_FACTURE', 'CLIENTS.CT_Num' , '=', 'DETAILS_FACTURE.CT_Num')
        ->select(
            // 'ENTETE_FACTURE.E_Signature',
             'ENTETE_FACTURE.DO_Piece',
             'ENTETE_FACTURE.DO_Date',
             'ENTETE_FACTURE.E_Signature',
             'CLIENTS.CT_Intitule',
        )///2022-02-07 00:00:00.000
           //  ->where('ENTETE_FACTURE.DO_Date' , '>=', $fromdate ." 00:00:00.000" )
            //->where('ENTETE_FACTURE.DO_Date', '<=', $todate ." 00:00:00.000")
             ->where('ENTETE_FACTURE.DO_Piece','like','%' .$name. '%')
             ->orderBy("ENTETE_FACTURE.DO_Date", 'desc')
             ->take(10)
             ->get();
        return view('report.report',compact('data'));
    }   */



    public function index(Request $request)
    {
     
        if(request()->ajax())
        {
         if(!empty($request->from_date))
         {
          $data = DB::table('clients')
            ->whereBetween('created_at', array($request->from_date, $request->to_date))
            ->get();
         }
         else
         {
          $data = DB::table('clients')
          ->orderBy('created_at', 'desc')
            ->get();
         }
         return datatables()->of($data)
         ->addIndexColumn()
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="view" id="'.$data->id.'" class="view btn btn-success btn-sm"> <i class="bi bi-eye"></i>View</button>';
                    $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                            
                    return $button;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$id}}" />')
               ->rawColumns(['checkbox','action'])
         ->make(true);
        }
        return view('report/result');
       

    }

    
    public function print($id)
    {
        $client = Client::findOrFail($id);

         // Check if the client exists
     if (!$client) {
     return response()->json(['error' => 'Client not found'], 404);
   }
        
        // Return the client data for editing
        return response()->json(['client' => $client], 200);

      
    }



    public function editClient($id)
    {
        $client = Client::find($id);
        
        // Check if the client exists
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }
        
        // Return the client data for editing
        return response()->json(['client' => $client], 200);

        
    }

    public function updateClient(Request $request, $id)
    {
        // Validate the incoming request data
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
            
            'has_passport' => 'nullable',
            'passport' => 'nullable|required_if:checkpasseport,oui',
            
            'has_cartejaune' => 'nullable',
            'has_payerinscription' => 'nullable',
            'has_permisconduire' => 'nullable',
            
            
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


   /*         'name' => 'required|string',
            'prenom' => 'required|string',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'email' => 'required|email',
            'cni' => 'required|string',
            'has_payerinscription' => 'required|in:non,oui',
            'enfant' => 'required|string',
            'marital_status' => 'required|in:single,married,divorce',
            'francais' => 'required|boolean',   */
        ]);

        // Find the client by ID and update the data
        $client = Client::findOrFail($id);

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

        $client->has_passport = $validatedData['has_passport'];
        $client->passport = $validatedData['passport'];
       

        $client->has_cartejaune = $validatedData['has_cartejaune'];
        $client->has_payerinscription = $validatedData['has_payerinscription'];
        $client->has_permisconduire = $validatedData['has_permisconduire'];

        $client->enfant = $validatedData['enfant'];

        $client->marital_status = $validatedData['marital_status'];
        
        $client->francais = $validatedData['francais'];
        $client->anglais = $validatedData['anglais'];
        $client->kiswahili = $validatedData['kiswahili'];
       
        $client->niveau = $validatedData['niveau'];

        $client->nom_avaliseur = $validatedData['nom_avaliseur'];
        $client->prenom_avaliseur = $validatedData['prenom_avaliseur'];
        $client->cni_avaliseur = $validatedData['cni_avaliseur'];
        $client->telephone_avaliseur = $validatedData['telephone_avaliseur'];
        $client->province_avaliseur = $validatedData['province_avaliseur'];
        $client->commune_avaliseur = $validatedData['commune_avaliseur'];
        
        $client->colline_avaliseur = $validatedData['colline_avaliseur'];
        $client->lien_parente = $validatedData['lien_parente'];

        $client->lien_parente = $validatedData['lien_parente'];
       


/*

        $client->name = $validatedData['name'];
        $client->prenom = $validatedData['prenom'];
        $client->gender = $validatedData['gender'];
        $client->date_of_birth = $validatedData['date_of_birth'];
        $client->email = $validatedData['email'];
        $client->cni = $validatedData['cni'];
        $client->has_payerinscription = $validatedData['has_payerinscription'];
        $client->enfant = $validatedData['enfant'];
        $client->marital_status = $validatedData['marital_status'];
        $client->francais = $validatedData['francais'];  */

        // Save the updated client data
        $client->save();

        // Return a response
        return response()->json(['message' => 'Client updated successfully']);
    }





    public function pdfView(){
        $projects = Client::all();
        return view('report/viewclient', compact('projects'));

    }


    public function pdfGeneration(){

        $projects = Client::all();

        $pdf = PDF::loadView('report/viewclient', compact('projects'));

        return $pdf->download('myPDF.pdf');
    }


  
public function generatePDF($clientID)
{
    $clientData = Client::find($clientID);
    // Récupérez les données du client depuis la requête ou toute autre méthode

    // Passer les données du client à la vue
    $view = View::make('report/pdf_view', compact('clientData'));

    // Rendre la vue en HTML
    $html = $view->render();

    // Créer une nouvelle instance de Dompdf
    $dompdf = new Dompdf();

    // Chargement du contenu HTML
    $dompdf->loadHtml($html);

    // Définir les options de mise en page
    $dompdf->setPaper('A4', 'portrait'); // Format A4 et orientation portrait
    $dompdf->set_option('isPhpEnabled', true); // Activer l'exécution de PHP dans le contenu HTML

    // Rendre le PDF
    $dompdf->render();

    // Générer une réponse avec le contenu du PDF
    $response = Response::make($dompdf->output(), 200);
    $response->header('Content-Type', 'application/pdf');
    return $response;
}

























    public function ajout_par_jour()
    {
// Retrieve today's record count for clients
$today = date('Y-m-d');
$recordCount = DB::table('clients')->whereDate('created_at', $today)->count();

// Retrieve the previous day's record count for clients
$previousRecordCount = DB::table('clients')->whereDate('created_at', today()->subDay())->count();

// Calculate the percentage increase compared to the previous day
$percentage = ($recordCount - $previousRecordCount) / $previousRecordCount * 100;

// Return the data as JSON response
return response()->json([
    'recordCount' => $recordCount,
    'percentage' => $percentage,
]);
    }





    public function ajout_par_mois()
    {
        // Get the start and end dates of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
    
        // Retrieve the clients registered in the current month
        $currentMonthClients = DB::table('clients')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
    
        // Get the start and end dates of the previous month
        $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();
    
        // Retrieve the clients registered in the previous month
        $previousMonthClients = DB::table('clients')
            ->whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
            ->count();
    
        // Calculate the percentage increase compared to the previous month
        $percentageIncrease = 0;
        if ($previousMonthClients > 0) {
            $percentageIncrease = (($currentMonthClients - $previousMonthClients) / $previousMonthClients) * 100;
        }
    
        // Return the data as a JSON response
        return response()->json([
            'currentMonthClients' => $currentMonthClients,
            'previousMonthClients' => $previousMonthClients,
            'percentageIncrease' => $percentageIncrease,
        ]);
    }



    public function ajoutParJour()
    {
        // Récupérer le nombre d'enregistrements d'aujourd'hui
        $recordCount = Enregistrement::whereDate('created_at', today())->count();

        // Récupérer le nombre d'enregistrements du jour précédent
        $previousRecordCount = Enregistrement::whereDate('created_at', today()->subDay())->count();

        // Calculer le pourcentage d'enregistrements par rapport au jour précédent
        $percentage = ($recordCount - $previousRecordCount) / $previousRecordCount * 100;

        // Retourner les données au format JSON
        return response()->json([
            'recordCount' => $recordCount,
            'percentage' => $percentage
        ]);
    }


    

//  ----------------------------------------------------------------------------------------------   
//           &&&&&&&&&&&&&&&&&&&&&&&&  **********************   &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
// --------------------------------------------------------------------------------------------


public function indexAssigeti(Request $request)
{
 
    
     
     
      $data = DB::table('DETAILS_FACTURE')
      ->join('ENTETE_FACTURE', 'DETAILS_FACTURE.DO_Piece' , '=', 'ENTETE_FACTURE.DO_Piece')
       // ->whereBetween('ENTETE_FACTURE.DO_Date', array($request->from_date, $request->to_date))
        ->where('AR_Ref',$request->selectedValue)
        ->get();
     
 
     return datatables()->of($data)
     ->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->E_Signature.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '   <button type="button" name="edit" id="'.$data->E_Signature.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
           // ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$id}}" />')
           ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$E_Signature}}" />') 
           ->rawColumns(['checkbox','action'])
     ->make(true);
    
    return view('report/result');
   

}


//  ----------------------------------------------------------------------------------------------    
// --------------------------------------------------------------------------------------------

public function fetch_data(Request $request)
{
    if($request->ajax())
    {
     if($request->from_date != '' && $request->to_date != '')
     {
      $data = DB::table('ENTETE_FACTURE')
        ->whereBetween('DO_Date', array($request->from_date, $request->to_date))
        ->get();
     }
     else
     {
      $data = DB::table('ENTETE_FACTURE')->orderBy('DO_Date', 'desc')->get();
     }
     echo json_encode($data);
    }
   
}


// --------------------------------------------------------------------------------------------
    //select 

    public function select(Request $request)
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

        $fromdate = $request->fromdate;
        $todate   = $request->todate;
        $name     = $request->name;


      //  $data = \DB::select("SELECT * FROM personals WHERE created_at BETWEEN '$fromdate 00:00:00'AND'$todate 23:59:59'");

        $data = DB::table('personals')
             ->where('created_at' , '>=', $fromdate ." 00:00:00" )
             ->where('created_at', '<=', $todate ." 23:59:59")
             ->where('username','like','%' .$name. '%')
             ->orderBy("created_at", 'desc')
             ->get();
        return view('report.report',compact('data'));
    }





    public function destroy($E_Signature)
    {
       // $data = User::findOrFail($E_Signature);
       $data = DB::table('ENTETE_FACTURE')
                ->findOrFail($E_Signature);
        $data->delete();
    }

/* 

    function removeall(Request $request)
    {
        $user_id_array = $request->input('E_Signature');
       // $user = User::whereIn('id', $user_id_array);

       $user = DB::table('ENTETE_FACTURE')
              // ->join('ENTETE_FACTURE', 'CLIENTS.CT_Num' , '=', 'ENTETE_FACTURE.DO_Tiers')
               ->join('DETAILS_FACTURE', 'ENTETE_FACTURE.DO_Tiers' , '=', 'DETAILS_FACTURE.CT_Num')
                ->select(
                                  

                         )
                 ->whereIn('E_Signature', $user_id_array)
                 ->get();



                                  $getClient=array();
                                  foreach($user as $user){
                                    $getClient[]=array(

                                        'tp_name'=>$user->DO_Piece,
                                        'tp_TIN'=>$user->DO_Piece,
                                      //--------------------------------
                                    );

                        }
                      $rr=  Personal::create([
                            'username'=> $user->DO_Piece,
                            'email' => $user->DO_Piece,
                            'phone'  => $user->CT_Num,
                            
                        ]);
                
        if($rr->create())
        {
            echo 'Data Deleted';
        }
    }*/



    /*$data = array();
$data['created_at'] =new \DateTime();
DB::table('practice')->insert($data); 
*/
Public function removeall(Request $request)
{
    $Invoice_signature = $request->input('E_Signature');
    if(!empty($Invoice_signature)){

        $timestamp = time();
        $currentDate = gmdate('Y-m-d', $timestamp);
       
        $data = DB::table('ENTETE_FACTURE')
        //  ->join('CLIENTS', 'ENTETE_FACTURE.DO_Tiers' , '=', 'CLIENTS.CT_Num')
       //   ->join('DETAILS_FACTURE', 'ENTETE_FACTURE.DO_Tiers' , '=', 'DETAILS_FACTURE.CT_Num')
          ->whereIn('E_Signature',$request->input('E_Signature'))
          ->get();

          $getClient=array();

          foreach($data as $data){
            // kurondera type ya produit nkorerako condition ya select
            $PFSUC=DB::table('DETAILS_FACTURE')
            ->where('DO_Piece',$data->DO_Piece)
            ->get('AR_Ref');

            // condiction ya select ya produit
            $ff=$PFSUC[0]->AR_Ref;
            $fff='PFSUC';
            if($ff == $fff){

            $userss = DB::table('DETAILS_FACTURE')
            ->where('DO_Piece',$data->DO_Piece)
            ->where('AR_Ref',$ff)
            ->get();

           // ku getinga resultat
            $dedee=array();

               foreach($userss as $userss){
                $dedee[]=array(
                  'item_designation' => $userss->DL_Design,
                  'item_quantity'  => $userss->DL_QteBC,
                  'item_price'  => $userss->DL_PrixUnitaire,
                  'item_ct'  => $userss->DL_QteBC*350,
                  'item_tl'  => $userss->DL_QteBC*31.58,
                  //'item_price_nvat' => $data->DO_TotalHTNet-($userss->DL_QteBC*22.08),

                 // && recent && 'item_price_nvat' => $userss->DL_QteBC * $userss->DL_PrixUnitaire,
                 'item_price_nvat' => $userss->DL_QteBC * 2676.62,

                  //'vat' => $data->DO_NetAPayer-$data->DO_TotalHTNet,

                 // && recent && 'vat' =>(($userss->DL_QteBC * $userss->DL_PrixUnitaire)*0.18),
                 'vat' =>(($userss->DL_QteBC * 2676.62)*0.18),

                 // 'item_price_wvat' => $data->DO_NetAPayer-$userss->DL_QteBC*22.08,

                  // && recent && 'item_price_wvat' => ($userss->DL_QteBC * $userss->DL_PrixUnitaire) + (($userss->DL_QteBC * $userss->DL_PrixUnitaire)*0.18),
                  'item_price_wvat' => ($userss->DL_QteBC * 2676.62) + (($userss->DL_QteBC * 2676.62)*0.18),

                 // && recent && 'item_total_amount' => $data->DO_NetAPayer,
                 'item_total_amount' => (($userss->DL_QteBC * 2676.62) + (($userss->DL_QteBC * 2676.62)*0.18)) + $userss->DL_QteBC*31.58,
                 //'item_total_amount' => (($userss->DL_QteBC * $userss->DL_PrixUnitaire) + (($userss->DL_QteBC * $userss->DL_PrixUnitaire)*0.18)) + $userss->DL_QteBC*22.08,
              //  item_price_nvat=Qte*2676.62
              //  vat=item_price_nvat*18/100


                );};
            
              }else{  //mugihe produit atagira TVA

                $userss = DB::table('DETAILS_FACTURE')
                ->where('DO_Piece',$data->DO_Piece)
                ->where('AR_Ref',$ff)
                ->get();

                $dedee=array();

                   foreach($userss as $userss){
                    $dedee[]=array(
                  'item_designation' => $userss->DL_Design,
                  'item_quantity'  => $userss->DL_QteBC,
                  'item_price'  => $userss->DL_PrixUnitaire,   
                  'item_ct'  => '0',
                  'item_tl'  => '0',
                // 'item_price_nvat' => $data->DO_TotalHTNet,
                  'item_price_nvat' =>  $userss->DL_QteBC * $userss->DL_PrixUnitaire,
                  'vat' => '0',
                  'item_price_wvat' => $data->DO_NetAPayer,
                // 'item_price_wvat' => $userss->DL_QteBC * $userss->DL_PrixUnitaire,
                  'item_total_amount' => $data->DO_NetAPayer,
                // 'item_total_amount' => $userss->DL_QteBC * $userss->DL_PrixUnitaire,
                  
                );};
              };

              $titi = json_encode([$dedee]);
      
      
                // convertir les dates 
      
                // convertir les dates ** invoice_date **
                $invoice_date = $data->DO_Date;
                $timestamp = strtotime($invoice_date); 
               $new_invoice_date = date("Y-m-d 00:00:00", $timestamp );
      
               // convertir les dates ** invoice_date **
               $invoice_signature_date = $data->DO_Date;
               $timestamp = strtotime($invoice_signature_date); 
              $new_invoice_signature_date = date("Y-m-d 00:00:00", $timestamp );
      
              // convertir assigety a la TVA **
              
              $u = DB::table('CLIENTS')
                ->where('CT_Num',$data->DO_Tiers)
                
                ->get();

       /*       // convertir les donnees des clients  
              $ret=$u[0]->CT_Ape;
               if(empty($ret)) {
                   $TVA = '0';
               } else{
                $TVA = '1';
               };     */
          
          
               $getClient[0]=array(
                    'invoice_number'=>$data->DO_Piece,
                    'invoice_date'  =>$new_invoice_date,
                    'invoice_type' => 'FN',
                    'tp_type'=>'2',
                    'tp_name'=>'SOSUMO SOCIETE SUCRIERE DU MOSO',
                    'tp_TIN'=>'4000004566',
                    'tp_trade_number' =>'23904',
                    'tp_postal_number' => 'BP835',
                    'tp_phone_number' =>'22507102',
                    'tp_address_province' =>'RUTANA',
                    'tp_address_commune' =>'BUKEMBA',
                    'tp_address_quartier' =>'GIHOFI', 
                    'tp_address_avenue'=> '',
                    'tp_address_number' => '',
                    'vat_taxpayer' =>'1', 
                    'ct_taxpayer' =>'1',
                    'tl_taxpayer' =>'1', 
                    'tp_fiscal_center' =>'DGC', 
                    'tp_activity_sector' =>'INDUSTRIE',
                    'tp_legal_form' =>'SM',
                    'payment_type' =>'4',
                    'invoice_currency' => 'BIF',
                    'customer_name' =>$data->DO_Ref,
                //  'customer_TIN' =>$u[0]->CT_Identifiant,
                //  'customer_address' =>$u[0]->CT_Adresse,
                 // 'vat_customer_payer' =>$TVA,
                    'customer_TIN' =>'',
                    'customer_address' =>'',
                    'vat_customer_payer' =>'',
                    'cancelled_invoice_ref' =>'',
                    'invoice_ref' => '',
                    'cn_motif' => '',
                    'invoice_signature'=>$data->E_Signature,
                    'invoice_signature_date' =>$new_invoice_signature_date,
                    'invoice_items' => $titi,
                    'created_at' =>$currentDate,
                    'updated_at' =>$currentDate,
                    ///////////////////////////////
                     'DO_Domaine'=>$data->DO_Domaine,
                     'DO_Type'=>$data->DO_Type,
                     'DO_Piece'=>$data->DO_Piece,
                     'DO_Date'=>$data->DO_Date,
                     'DO_Ref'=>$data->DO_Ref,
                     'DO_Tiers'=>$data->DO_Tiers,
                     'cbDO_Tiers'=>$data->cbDO_Tiers,
                     'CO_No'=>$data->CO_No,
                     'cbCO_No'=>$data->cbCO_No,
                     'DO_Period'=>$data->DO_Period,
                     'DO_Devise'=>$data->DO_Devise,
                     'DO_Cours'=>$data->DO_Cours,
                     'DE_No'=>$data->DE_No,
                     'cbDE_No'=>$data->cbDE_No,
                     'LI_No'=>$data->LI_No,
                     'cbLI_No'=>$data->cbLI_No,
                     'CT_NumPayeur'=>$data->CT_NumPayeur,
                     'cbCT_NumPayeur'=>$data->cbCT_NumPayeur,
                     'DO_Expedit'=>$data->DO_Expedit,
                     'DO_NbFacture'=>$data->DO_NbFacture,
                     'DO_BLFact'=>$data->DO_BLFact,
                     'DO_TxEscompte'=>$data->DO_TxEscompte,
                     'DO_Reliquat'=>$data->DO_Reliquat,
                     'DO_Imprim'=>$data->DO_Imprim,
                     'CA_Num'=>$data->CA_Num,
                     'cbCA_Num'=>$data->cbCA_Num,
                     'DO_Coord01'=>$data->DO_Coord01,
                     'DO_Coord02'=>$data->DO_Coord02,
                     'DO_Coord03'=>$data->DO_Coord03,
                     'DO_Coord04'=>$data->DO_Coord04,
                     'DO_Souche'=>$data->DO_Souche,
                     'DO_DateLivr'=>$data->DO_DateLivr,
                     'DO_Condition'=>$data->DO_Condition,
                     'DO_Tarif'=>$data->DO_Tarif,
                     'DO_Colisage'=>$data->DO_Colisage,
                     'DO_TypeColis'=>$data->DO_TypeColis,
                     'DO_Transaction'=>$data->DO_Transaction,
                     'DO_Langue'=>$data->DO_Langue,
                     'DO_Ecart'=>$data->DO_Ecart,
                     'DO_Regime'=>$data->DO_Regime,
                     'N_CatCompta'=>$data->N_CatCompta,
                     'DO_Ventile'=>$data->DO_Ventile,
                     'AB_No'=>$data->AB_No,
                     'DO_DebutAbo'=>$data->DO_DebutAbo,
                     'DO_FinAbo'=>$data->DO_FinAbo,
                     'DO_DebutPeriod'=>$data->DO_DebutPeriod,
                     'DO_FinPeriod'=>$data->DO_FinPeriod,
                     'CG_Num'=>$data->CG_Num,
                     'cbCG_Num'=>$data->cbCG_Num,
                     'DO_Statut'=>$data->DO_Statut,
                     'DO_Heure'=>$data->DO_Heure,
                     'CA_No'=>$data->CA_No,
                     'CO_NoCaissier'=>$data->CO_NoCaissier,
                     'cbCO_NoCaissier'=>$data->cbCO_NoCaissier,
                     'DO_Transfere'=>$data->DO_Transfere,
                     'DO_Cloture'=>$data->DO_Cloture,
                     'DO_NoWeb'=>$data->DO_NoWeb,
                     'DO_Attente'=>$data->DO_Attente,
                     'DO_Provenance'=>$data->DO_Provenance,
                     'CA_NumIFRS'=>$data->CA_NumIFRS,
                     'MR_No'=>$data->MR_No,
                     'DO_TypeFrais'=>$data->DO_TypeFrais,
                     'DO_ValFrais'=>$data->DO_ValFrais,
                     'DO_TypeLigneFrais'=>$data->DO_TypeLigneFrais,
                     'DO_TypeFranco'=>$data->DO_TypeFranco,
                     'DO_ValFranco'=>$data->DO_ValFranco,
                     'DO_TypeLigneFranco'=>$data->DO_TypeLigneFranco,
                     'DO_Taxe1'=>$data->DO_Taxe1,
                     'DO_TypeTaux1'=>$data->DO_TypeTaux1,
                     'DO_TypeTaxe1'=>$data->DO_TypeTaxe1,
                     'DO_Taxe2'=>$data->DO_Taxe2,
                     'DO_TypeTaux2'=>$data->DO_TypeTaux2,
                     'DO_TypeTaxe2'=>$data->DO_TypeTaxe2,
                     'DO_Taxe3'=>$data->DO_Taxe3,
                     'DO_TypeTaux3'=>$data->DO_TypeTaux3,
                     'DO_TypeTaxe3'=>$data->DO_TypeTaxe3,
                     'DO_MajCpta'=>$data->DO_MajCpta,
                     'DO_Motif'=>$data->DO_Motif,
                     'CT_NumCentrale'=>$data->CT_NumCentrale,
                     'cbCT_NumCentrale'=>$data->cbCT_NumCentrale,
                     'DO_Contact'=>$data->DO_Contact,
                     'DO_FactureElec'=>$data->DO_FactureElec,
                     'DO_TypeTransac'=>$data->DO_TypeTransac,
                     'DO_DateLivrRealisee'=>$data->DO_DateLivrRealisee,
                     'DO_DateExpedition'=>$data->DO_DateExpedition,
                     'DO_FactureFrs'=>$data->DO_FactureFrs,
                     'cbDO_FactureFrs'=>$data->cbDO_FactureFrs,
                     'DO_PieceOrig'=>$data->DO_PieceOrig,
                     'DO_GUID'=>$data->DO_GUID,
                     'DO_EStatut'=>$data->DO_EStatut,
                     'DO_DemandeRegul'=>$data->DO_DemandeRegul,
                     'ET_No'=>$data->ET_No,
                     'cbET_No'=>$data->cbET_No,
                     'DO_Valide'=>$data->DO_Valide,
                     'DO_Coffre'=>$data->DO_Coffre,
                     'DO_CodeTaxe1'=>$data->DO_CodeTaxe1,
                     'DO_CodeTaxe2'=>$data->DO_CodeTaxe2,
                     'DO_CodeTaxe3'=>$data->DO_CodeTaxe3,
                     'DO_TotalHT'=>$data->DO_TotalHT,
                     'DO_StatutBAP'=>$data->DO_StatutBAP,
                     'cbProt'=>$data->cbProt,
                     'cbMarq'=>$data->cbMarq,
                     'cbCreateur'=>$data->cbCreateur,
                     'cbModification'=>$data->cbModification,
                     'cbReplication'=>$data->cbReplication,
                     'cbFlag'=>$data->cbFlag,
                     'cbCreation'=>$data->cbCreation,
                     'cbCreationUser'=>$data->cbCreationUser,
                     'DO_Escompte'=>$data->DO_Escompte,
                     'DO_DocType'=>$data->DO_DocType,
                     'DO_TypeCalcul'=>$data->DO_TypeCalcul,
                     'DO_FactureFile'=>$data->DO_FactureFile,
                     'DO_TotalHTNet'=>$data->DO_TotalHTNet,
                     'DO_TotalTTC'=>$data->DO_TotalTTC,
                     'DO_NetAPayer'=>$data->DO_NetAPayer,
                     'DO_MontantRegle'=>$data->DO_MontantRegle,
                     'DO_RefPaiement'=>$data->DO_RefPaiement,
                     'DO_AdressePaiement'=>$data->DO_AdressePaiement,
                     'DO_PaiementLigne'=>$data->DO_PaiementLigne,
                     'DO_MotifDevis'=>$data->DO_MotifDevis,
                     'DO_Conversion'=>$data->DO_Conversion,
                      //'cbHash'=>$data->cbHash,
                     'cbHashVersion'=>$data->cbHashVersion,
                     'cbHashDate'=>$data->cbHashDate,
                     'cbHashOrder'=>$data->cbHashOrder,
                     'cbDO_Piece'=>$data->cbDO_Piece,
                     'cbCA_No'=>$data->cbCA_No,
                     'cbDO_PieceOrig'=>$data->cbDO_PieceOrig,
                     'E_Signature'=>$data->E_Signature,
      
                   );
     
     
     
        //  ********************************URL******************************************************  //  
             $res = Http::post('https://ebms.obr.gov.bi:8443/ebms_api/login/', [


                "username" => "wsl400000456600352",
                "password" => "\\E3pn~;f",

            //  "username" => "ws400000456600327",
            //  "password" => "8G^c{2T1",
             
              ]);

           $json= json_decode($res->getBody());
           $token = $json->result->token;
           //var_dump($token);
           //echo $token;
           
           // echo $json[0]['token'];
           // var_dump($response);

            $response = Http::withHeaders([
          'Authorization' => 'Bearer '.$token
           ])->post("https://ebms.obr.gov.bi:8443/ebms_api/addInvoice/", [    
            
           // https://ebms.obr.gov.bi:9443/ebms_api/addInvoice/         
      
              //   $response = Http::post("http://127.0.0.1:8002/api/add/create", [
      
          
                'invoice_number'=>$data->DO_Piece,
                'invoice_date'  =>$new_invoice_date,
                'invoice_type' => 'FN',
                'tp_type'=>'2',
                'tp_name'=>'SOSUMO SOCIETE SUCRIERE DU MOSO',
                'tp_TIN'=>'4000004566',
                'tp_trade_number' =>'23904',
                'tp_postal_number' => 'BP835',
                'tp_phone_number' =>'22507102',
                'tp_address_province' =>'RUTANA',
                'tp_address_commune' =>'BUKEMBA',
                'tp_address_quartier' =>'GIHOFI', 
                'tp_address_avenue'=> '',
                'tp_address_number' => '',
                'vat_taxpayer' =>'1', 
                'ct_taxpayer' =>'1',
                'tl_taxpayer' =>'1', 
                'tp_fiscal_center' =>'DGC', 
                'tp_activity_sector' =>'INDUSTRIE',
                'tp_legal_form' =>'SM',
                'payment_type' =>'4',
                'invoice_currency' => 'BIF',
                'customer_name' =>$data->DO_Ref,
           //   'customer_TIN' =>$u[0]->CT_Identifiant,
          //    'customer_address' =>$u[0]->CT_Adresse,
          //    'vat_customer_payer' =>$TVA,
                'customer_TIN' =>'',
                'customer_address' =>'',
                'vat_customer_payer' =>'',
                'cancelled_invoice_ref' =>'',
                'invoice_ref' => '',
                'cn_motif' => '',
      
                'invoice_signature'=>$data->E_Signature,
                'invoice_signature_date' =>$new_invoice_signature_date,
                'invoice_items' => $dedee,        
      
      
              ]);
      
        //  ******************************URL********************************************************  //  
      
                      
        
             DB::table('sendeds')->insert($getClient[0]);
            DB::table('ENTETE_FACTURE')->whereIn('E_Signature',$request->input('E_Signature'))->delete();
                 }

       return $response->json();
  //  $sended = sended::create($user_id_array);
   // dd($sended->data);
    

    }else{
        $checkbox = '';
        }
        return redirect()->back();
    }



    /*    function removeall(Request $request)
    {
        $user_id_array = $request->input('E_Signature');
       // $user = User::whereIn('id', $user_id_array);

       $user = DB::table('ENTETE_FACTURE')
                ->whereIn('E_Signature', $user_id_array);
        if($user->delete())
        {
            echo 'Data Deleted';
        }
    } */
 

}
