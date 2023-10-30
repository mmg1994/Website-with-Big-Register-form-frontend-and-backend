@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.dashboard')
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

</head>
 <body>

  <div class="col-lg-9 mx-auto" >    
     <br />
     <h2 align="center">liste des factures à envoyer</h2><hr>
     <br />
     @csrf

     
     <!--<input type="text" id="fname" name="fname"><br><br> -->
    
            <div class="row input-daterange">

                <div class="col-md-2">
                     <select name="fetchval" id="fetchval">
                        <option value=""></option>
                        
                        <option value="PFSUC" id="PFSUC">PFSUC</option>
                        <option value="PFSUCIMP" id="PFSUCIMP">PFSUCIMP</option>
                        <option value="BD20L" id="BD20L">BD20L</option>


                    </select>
                </div>

               
                
                
                <div class="col-md-3">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col-md-3">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                </div>
                


                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-primary">Refresh</button>
                    <button type="button" name="export_excel" id="export_excel" class="btn btn-primary">export excel</button>
               <!--     <button type="button" name="bulk_delete" id="bulk_delete" style="padding_left: 20px" class="btn btn-danger btn-xs">send to OBR</button>  -->
                </div>
            </div>
            <br />
   <div class="table-responsive" >
   <div id="loader" class="modal-dialog" style="display: none; height: 100px;
  width: 100px; position:center; margin_left: 50px; top: 0px; z-index: 99999; ">
     <img src='/assets/image/loading.gif' style=" background-color: #555;  height: 100px;
  width: 100px; position:center; margin_left: 50px; top: 0px; z-index: 99999; "> <b> loading..</b>
    </div>
    <table class="table table-bordered table-striped" id="order_table" >
           <thead>
            <tr>
               <!-- <th>Order ID</th> -->
                <th>Nom</th>
                <th>Prenom</th>
                <th>Telephone</th>
                <th >Email</th>
                <th >Date d'enregistrement</th>
                <th >Action</th>  
             <th><input type="checkbox" id="master" ></th>
                
            </tr>
           </thead>
           @include('report.formclient')
            @include('report.viewclient')
            @include('report.print')
            </table>
        </div>
        



   <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" id="sample_form" class="form-horizontal">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
            </div>
        </form>  
        </div>
        </div>
    </div>

  </div>
   </body>
   <script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
   <script src="https://unpkg.com/exceljs/dist/exceljs.min.js"></script>
   <script src="https://unpkg.com/FileSaver.js"></script>
  </head>
<body>
  
  <script>
$(document).ready(function(){

// select all

    $(function(e){

    $("#master").click(function(){
        $('.users_checkbox').prop('checked',$(this).prop('checked'));

    });

    });




 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
 });




 // -------------------------------------------------------------------------------------

        load_data();

        function load_data(from_date = '', to_date = '')
        {
          $('#order_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url:'{{ route("/date") }}',
            data:{from_date:from_date, to_date:to_date}
          },
          columns: [
                    {data: 'name', name: 'name'},
                    {data: 'prenom', name: 'prenom'},
                    {data: 'telephone', name: 'telephone'},
                    {data:'email',name:'email'},
                    {data:'created_at',name:'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false},
            
            ],
            "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
            "pageLength": 10,
            "searching": false
          });
        }


             $('#filter').click(function() {
                table.draw();
             });

            $('#select_all').click(function() {
                $('input:checkbox.users_checkbox').not(this).prop('checked', this.checked);
            });



// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&



$(document).on('click', '.export_excel', function() {
  exportToExcel();
});


function exportToExcel() {
  let table = $('#order_table').DataTable();
  let data = table.rows().data().toArray();

  // Créer une feuille de calcul avec les données du tableau
  let worksheet = XLSX.utils.json_to_sheet(data);

  // Créer un classeur et ajouter la feuille de calcul
  let workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Feuille1");

  // Convertir le classeur en un flux de données binaire
  let excelData;
  try {
    excelData = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
  } catch (error) {
    console.error("Erreur lors de la conversion en fichier Excel :", error);
    alert("Une erreur s'est produite lors de l'exportation vers Excel.");
    return;
  }

  // Créer un objet Blob à partir des données Excel
  let blob = new Blob([excelData], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

  // Télécharger le fichier Excel
  try {
    saveAs(blob, "tableau.xlsx");
  } catch (error) {
    console.error("Erreur lors du téléchargement du fichier Excel :", error);
    alert("Une erreur s'est produite lors du téléchargement du fichier Excel.");
  }
}














// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&





















      
//###########################   edit debut #####################################################################################

    $(document).on('click', '.edit', function() {
      var clientID = $(this).attr('id');

        // Hide the table
        $('#order_table').hide();

        // Perform edit action
        $.ajax({
          url: "/clients/" + clientID + "/edit", // Replace with your edit route URL
          type: "GET",
          success: function(response) {
            // Handle the success response
            var clientData = response.client;
            console.log(clientData);
            // Set the form field values
            $('#id').val(clientData.id);
            $('#name').val(clientData.name);
            $('#prenom').val(clientData.prenom);

          // Set the gender radio button
          if (clientData.gender === 'male') {
            $('#male').prop('checked', true);
          } else if (clientData.gender === 'female') {
            $('#female').prop('checked', true);
          }

          //from step 1
          $('#nom_pere').val(clientData.nom_pere);
          $('#prenom_pere').val(clientData.prenom_pere);
          $('#nom_mere').val(clientData.nom_mere);
          $('#prenom_mere').val(clientData.prenom_mere);
          $('#date_of_birth').val(clientData.date_of_birth);
          $('#province').val(clientData.province);
          $('#commune').val(clientData.commune);
          $('#colline').val(clientData.colline);
          $('#residence_actuel').val(clientData.residence_actuel);
          $('#nationalite').val(clientData.nationalite);
          $('#religion').val(clientData.religion);
          $('#telephone').val(clientData.telephone);
          $('#email').val(clientData.email);


          //from step 2
          $('#cni').val(clientData.cni);

        // Set the checkpasseport radio button
        if (clientData.has_passport) {
              $('#has_passport').val("true");
              $('#has_passport option[value="1"]').prop('selected', true);
              } else {
              $('#has_passport').val("false");
              $('#has_passport option[value="0"]').prop('selected', true);
              }


          $('#passport').val(clientData.passport);

        // Set the checkcartejaune radio button
            if (clientData.has_cartejaune) {
              $('#has_cartejaune').val("true");
              $('#has_cartejaune option[value="1"]').prop('selected', true);
              } else {
              $('#has_cartejaune').val("false");
              $('#has_cartejaune option[value="0"]').prop('selected', true);
              }





        // Set the checkpayerinscription radio button

        if (clientData.has_payerinscription) {
              $('#has_payerinscription').val("true");
              $('#has_payerinscription option[value="1"]').prop('selected', true);
              } else {
              $('#has_payerinscription').val("false");
              $('#has_payerinscription option[value="0"]').prop('selected', true);
              }




          // Set the checkpermisconduire radio button
          if (clientData.has_permisconduire) {
              $('#has_permisconduire').val("true");
              $('#has_permisconduire option[value="1"]').prop('selected', true);
              } else {
              $('#has_permisconduire').val("false");
              $('#has_permisconduire option[value="0"]').prop('selected', true);
              }




          $('#enfant').val(clientData.enfant);


          // Set the marital_status radio button
        if (clientData.marital_status === 'single') {
            $('#single').prop('checked', true);
          } else if (clientData.marital_status === 'married') {
            $('#married').prop('checked', true);
          }else if (clientData.marital_status === 'divorce') {
            $('#divorce').prop('checked', true);
          }


          //from step 3

              if (clientData.francais) {
              $('#francais').val("true");
              $('#francais option[value="1"]').prop('selected', true);
              } else {
              $('#francais').val("false");
              $('#francais option[value="0"]').prop('selected', true);
              }

              if (clientData.anglais) {
              $('#anglais').val("true");
              $('#anglais option[value="1"]').prop('selected', true);
              } else {
              $('#anglais').val("false");
              $('#anglais option[value="0"]').prop('selected', true);
              }

              if (clientData.kiswahili) {
              $('#kiswahili').val("true");
              $('#kiswahili option[value="1"]').prop('selected', true);
              } else {
              $('#kiswahili').val("false");
              $('#kiswahili option[value="0"]').prop('selected', true);
              }


          // Set the niveau radio button
          if (clientData.niveau === 'a2') {
            $('#a2').prop('checked', true);
          } else if (clientData.niveau === 'licence') {
            $('#licence').prop('checked', true);
          }else if (clientData.niveau === '10e') {
            $('#10e').prop('checked', true);
          }else if (clientData.niveau === '9e') {
            $('#9e').prop('checked', true);
          }


          $('#nom_avaliseur').val(clientData.nom_avaliseur);
          $('#prenom_avaliseur').val(clientData.prenom_avaliseur);
          $('#cni_avaliseur').val(clientData.cni_avaliseur);
          $('#telephone_avaliseur').val(clientData.telephone_avaliseur);
          $('#province_avaliseur').val(clientData.province_avaliseur);
          $('#commune_avaliseur').val(clientData.commune_avaliseur);
          $('#colline_avaliseur').val(clientData.colline_avaliseur);
          $('#lien_parente').val(clientData.lien_parente);
      






            // Show the form
            $('#client-details-form').show();
          },
          error: function(xhr, status, error) {
            // Handle the error response
            console.log(xhr.responseText);
          }
        });
    });



//###########################   edit fin #####################################################################################



//###########################  view debut  #####################################################################################

$(document).on('click', '.view', function() {
      var clientID = $(this).attr('id');

        // Hide the table
        $('#order_table').hide();

        // Perform edit action
        $.ajax({
          url: "/clients/" + clientID + "/edit", // Replace with your edit route URL
          type: "GET",
          success: function(response) {
            // Handle the success response
            var clientData = response.client;
            console.log(clientData);
            // Set the form field values
            $('#id_v').val(clientData.id);
            $('#name_v').val(clientData.name);
            $('#prenom_v').val(clientData.prenom);

            if (clientData.profile_image) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + clientData.profile_image;
                $('#profile_image_v').attr('src', imagePath);
                
                // Set image dimensions
                $('#profile_image_v').attr('width', 180); // Remplacer par la largeur souhaitée
                $('#profile_image_v').attr('height', 220); // Remplacer par la hauteur souhaitée
                
                $('#profile_image_v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#profile_image_v').attr('src', '');
                $('#profile_image_v').removeAttr('width');
                $('#profile_image_v').removeAttr('height');
                $('#profile_image_v').hide();
              }


              if (clientData.diplome_client) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + clientData.diplome_client;
                $('#diplome_client_v').attr('src', imagePath);
                
                // Set image dimensions
                $('#diplome_client_v').attr('width', 450); // Remplacer par la largeur souhaitée
                $('#diplome_client_v').attr('height', 750); // Remplacer par la hauteur souhaitée
                
                $('#diplome_client_v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#diplome_client_v').attr('src', '');
                $('#diplome_client_v').removeAttr('width');
                $('#diplome_client_v').removeAttr('height');
                $('#diplome_client_v').hide();
              }


              if (clientData.carteid_client) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + clientData.carteid_client;
                $('#carteid_client_v').attr('src', imagePath);
                
                // Set image dimensions
                $('#carteid_client_v').attr('width', 450); // Remplacer par la largeur souhaitée
                $('#carteid_client_v').attr('height', 750); // Remplacer par la hauteur souhaitée
                
                $('#carteid_client_v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#carteid_client_v').attr('src', '');
                $('#carteid_client_v').removeAttr('width');
                $('#carteid_client_v').removeAttr('height');
                $('#carteid_client_v').hide();
              }



              if (clientData.att_ident_compl_client) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + clientData.att_ident_compl_client;
                $('#att_ident_compl_client_v').attr('src', imagePath);
                
                // Set image dimensions
                $('#att_ident_compl_client_v').attr('width', 450); // Remplacer par la largeur souhaitée
                $('#att_ident_compl_client_v').attr('height', 750); // Remplacer par la hauteur souhaitée
                
                $('#att_ident_compl_client_v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#att_ident_compl_client_v').attr('src', '');
                $('#att_ident_compl_client_v').removeAttr('width');
                $('#att_ident_compl_client_v').removeAttr('height');
                $('#att_ident_compl_client_v').hide();
              }



    


          // Set the gender radio button
          if (clientData.gender === 'male') {
            $('#male_v').prop('checked', true);
          } else if (clientData.gender === 'female') {
            $('#female_v').prop('checked', true);
          }

          //from step 1
          $('#nom_pere_v').val(clientData.nom_pere);
          $('#prenom_pere_v').val(clientData.prenom_pere);
          $('#nom_mere_v').val(clientData.nom_mere);
          $('#prenom_mere_v').val(clientData.prenom_mere);
          $('#date_of_birth_v').val(clientData.date_of_birth);
          $('#province_v').val(clientData.province);
          $('#commune_v').val(clientData.commune);
          $('#colline_v').val(clientData.colline);
          $('#residence_actuel_v').val(clientData.residence_actuel);
          $('#nationalite_v').val(clientData.nationalite);
          $('#religion_v').val(clientData.religion);
          $('#telephone_v').val(clientData.telephone);
          $('#email_v').val(clientData.email);


          //from step 2
          $('#cni_v').val(clientData.cni);

        // Set the checkpasseport radio button
        if (clientData.has_passport) {
              $('#has_passport_v').val("true");
              $('#has_passport_v option[value="1"]').prop('selected', true);
              } else {
              $('#has_passport_v').val("false");
              $('#has_passport_v option[value="0"]').prop('selected', true);
              }


          $('#passport_v').val(clientData.passport);

        // Set the checkcartejaune radio button
            if (clientData.has_cartejaune) {
              $('#has_cartejaune_v').val("true");
              $('#has_cartejaune_v option[value="1"]').prop('selected', true);
              } else {
              $('#has_cartejaune_v').val("false");
              $('#has_cartejaune_v option[value="0"]').prop('selected', true);
              }





        // Set the checkpayerinscription radio button

        if (clientData.has_payerinscription) {
              $('#has_payerinscription_v').val("true");
              $('#has_payerinscription_v option[value="1"]').prop('selected', true);
              } else {
              $('#has_payerinscription_v').val("false");
              $('#has_payerinscription_v option[value="0"]').prop('selected', true);
              }




          // Set the checkpermisconduire radio button
          if (clientData.has_permisconduire) {
              $('#has_permisconduire_v').val("true");
              $('#has_permisconduire_v option[value="1"]').prop('selected', true);
              } else {
              $('#has_permisconduire_v').val("false");
              $('#has_permisconduire_v option[value="0"]').prop('selected', true);
              }




          $('#enfant_v').val(clientData.enfant);


          // Set the marital_status radio button
        if (clientData.marital_status === 'single') {
            $('#single_v').prop('checked', true);
          } else if (clientData.marital_status === 'married') {
            $('#married_v').prop('checked', true);
          }else if (clientData.marital_status === 'divorce') {
            $('#divorce_v').prop('checked', true);
          }


          //from step 3

              if (clientData.francais) {
              $('#francais_v').val("true");
              $('#francais_v option[value="1"]').prop('selected', true);
              } else {
              $('#francais_v').val("false");
              $('#francais_v option[value="0"]').prop('selected', true);
              }

              if (clientData.anglais) {
              $('#anglais_v').val("true");
              $('#anglais_v option[value="1"]').prop('selected', true);
              } else {
              $('#anglais_v').val("false");
              $('#anglais_v option[value="0"]').prop('selected', true);
              }

              if (clientData.kiswahili) {
              $('#kiswahili_v').val("true");
              $('#kiswahili_v option[value="1"]').prop('selected', true);
              } else {
              $('#kiswahili_v').val("false");
              $('#kiswahili_v option[value="0"]').prop('selected', true);
              }


          // Set the niveau radio button
          if (clientData.niveau === 'a2') {
            $('#a2_v').prop('checked', true);
          } else if (clientData.niveau === 'licence') {
            $('#licence_v').prop('checked', true);
          }else if (clientData.niveau === '10e') {
            $('#10e_v').prop('checked', true);
          }else if (clientData.niveau === '9e') {
            $('#9e_v').prop('checked', true);
          }


          $('#nom_avaliseur_v').val(clientData.nom_avaliseur);
          $('#prenom_avaliseur_v').val(clientData.prenom_avaliseur);
          $('#cni_avaliseur_v').val(clientData.cni_avaliseur);
          $('#telephone_avaliseur_v').val(clientData.telephone_avaliseur);
          $('#province_avaliseur_v').val(clientData.province_avaliseur);
          $('#commune_avaliseur_v').val(clientData.commune_avaliseur);
          $('#colline_avaliseur_v').val(clientData.colline_avaliseur);
          $('#lien_parente_v').val(clientData.lien_parente);
      






            // Show the form
            $('#client_details_view').show();
          },
          error: function(xhr, status, error) {
            // Handle the error response
            console.log(xhr.responseText);
          }
        });
    });


//###########################  view fin  #####################################################################################

//Route::get('/clients/{id}/edit', [ReportController::class,'editClient'])->name('clients.edit');



var selectedClient; 

$('#order_table').on('click', '.view', function() {
  selectedClient = $(this).attr('id');
  //getClient(selectedClientID);
 // printclient(selectedClient);
});
var selectedClientData; // Global variable to store the client data

$(document).on('click', '#Print', function() {
  // Assuming you want to print client with ID 1

  // Fetch client data via AJAX
  $.ajax({
    url: '/clients/print/' + selectedClient + "/print",
    type: 'GET',
    success: function(response) {
      selectedClientData = response.client; // Assign client data to the global variable
      console.log(selectedClientData);

      $('#id_y').val(selectedClientData.id);
      $('#name_y').val(selectedClientData.name);
      $('#prenom_y').val(selectedClientData.prenom);



      $('#id_1v').val(selectedClientData.id);
            $('#name_1v').val(selectedClientData.name);
            $('#prenom_1v').val(selectedClientData.prenom);

            if (selectedClientData.profile_image) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + selectedClientData.profile_image;
                $('#profile_image_1v').attr('src', imagePath);
                
                // Set image dimensions
                $('#profile_image_1v').attr('width', 180); // Remplacer par la largeur souhaitée
                $('#profile_image_1v').attr('height', 220); // Remplacer par la hauteur souhaitée
                
                $('#profile_image_1v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#profile_image_1v').attr('src', '');
                $('#profile_image_1v').removeAttr('width');
                $('#profile_image_1v').removeAttr('height');
                $('#profile_image_1v').hide();
              }


              if (selectedClientData.diplome_client) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + selectedClientData.diplome_client;
                $('#diplome_client_1v').attr('src', imagePath);
                
                // Set image dimensions
                $('#diplome_client_1v').attr('width', 450); // Remplacer par la largeur souhaitée
                $('#diplome_client_1v').attr('height', 750); // Remplacer par la hauteur souhaitée
                
                $('#diplome_client_1v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#diplome_client_1v').attr('src', '');
                $('#diplome_client_1v').removeAttr('width');
                $('#diplome_client_1v').removeAttr('height');
                $('#diplome_client_1v').hide();
              }


              if (selectedClientData.carteid_client) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + selectedClientData.carteid_client;
                $('#carteid_client_1v').attr('src', imagePath);
                
                // Set image dimensions
                $('#carteid_client_1v').attr('width', 450); // Remplacer par la largeur souhaitée
                $('#carteid_client_1v').attr('height', 750); // Remplacer par la hauteur souhaitée
                
                $('#carteid_client_1v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#carteid_client_1v').attr('src', '');
                $('#carteid_client_1v').removeAttr('width');
                $('#carteid_client_1v').removeAttr('height');
                $('#carteid_client_1v').hide();
              }



              if (selectedClientData.att_ident_compl_client) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + selectedClientData.att_ident_compl_client;
                $('#att_ident_compl_client_1v').attr('src', imagePath);
                
                // Set image dimensions
                $('#att_ident_compl_client_1v').attr('width', 450); // Remplacer par la largeur souhaitée
                $('#att_ident_compl_client_1v').attr('height', 750); // Remplacer par la hauteur souhaitée
                
                $('#att_ident_compl_client_1v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#att_ident_compl_client_1v').attr('src', '');
                $('#att_ident_compl_client_1v').removeAttr('width');
                $('#att_ident_compl_client_1v').removeAttr('height');
                $('#att_ident_compl_client_1v').hide();
              }



    


          // Set the gender radio button
          if (selectedClientData.gender === 'male') {
            $('#male_1v').prop('checked', true);
          } else if (selectedClientData.gender === 'female') {
            $('#female_1v').prop('checked', true);
          }

          //from step 1
          $('#nom_pere_1v').val(selectedClientData.nom_pere);
          $('#prenom_pere_1v').val(selectedClientData.prenom_pere);
          $('#nom_mere_1v').val(selectedClientData.nom_mere);
          $('#prenom_mere_1v').val(selectedClientData.prenom_mere);
          $('#date_of_birth_1v').val(selectedClientData.date_of_birth);
          $('#province_1v').val(selectedClientData.province);
          $('#commune_1v').val(selectedClientData.commune);
          $('#colline_1v').val(selectedClientData.colline);
          $('#residence_actuel_1v').val(selectedClientData.residence_actuel);
          $('#nationalite_1v').val(selectedClientData.nationalite);
          $('#religion_1v').val(selectedClientData.religion);
          $('#telephone_1v').val(selectedClientData.telephone);
          $('#email_1v').val(selectedClientData.email);


          //from step 2
          $('#cni_1v').val(selectedClientData.cni);

        // Set the checkpasseport radio button
        if (selectedClientData.has_passport) {
              $('#has_passport_1v').val("true");
              $('#has_passport_1v option[value="1"]').prop('selected', true);
              } else {
              $('#has_passport_1v').val("false");
              $('#has_passport_1v option[value="0"]').prop('selected', true);
              }


          $('#passport_1v').val(selectedClientData.passport);

        // Set the checkcartejaune radio button
            if (selectedClientData.has_cartejaune) {
              $('#has_cartejaune_1v').val("true");
              $('#has_cartejaune_1v option[value="1"]').prop('selected', true);
              } else {
              $('#has_cartejaune_1v').val("false");
              $('#has_cartejaune_1v option[value="0"]').prop('selected', true);
              }





        // Set the checkpayerinscription radio button

        if (selectedClientData.has_payerinscription) {
              $('#has_payerinscription_1v').val("true");
              $('#has_payerinscription_1v option[value="1"]').prop('selected', true);
              } else {
              $('#has_payerinscription_1v').val("false");
              $('#has_payerinscription_1v option[value="0"]').prop('selected', true);
              }




          // Set the checkpermisconduire radio button
          if (selectedClientData.has_permisconduire) {
              $('#has_permisconduire_1v').val("true");
              $('#has_permisconduire_1v option[value="1"]').prop('selected', true);
              } else {
              $('#has_permisconduire_1v').val("false");
              $('#has_permisconduire_1v option[value="0"]').prop('selected', true);
              }




          $('#enfant_1v').val(selectedClientData.enfant);


          // Set the marital_status radio button
        if (selectedClientData.marital_status === 'single') {
            $('#single_1v').prop('checked', true);
          } else if (selectedClientData.marital_status === 'married') {
            $('#married_1v').prop('checked', true);
          }else if (selectedClientData.marital_status === 'divorce') {
            $('#divorce_1v').prop('checked', true);
          }


          //from step 3

              if (selectedClientData.francais) {
              $('#francais_1v').val("true");
              $('#francais_1v option[value="1"]').prop('selected', true);
              } else {
              $('#francais_1v').val("false");
              $('#francais_1v option[value="0"]').prop('selected', true);
              }

              if (selectedClientData.anglais) {
              $('#anglais_1v').val("true");
              $('#anglais_1v option[value="1"]').prop('selected', true);
              } else {
              $('#anglais_1v').val("false");
              $('#anglais_1v option[value="0"]').prop('selected', true);
              }

              if (selectedClientData.kiswahili) {
              $('#kiswahili_1v').val("true");
              $('#kiswahili_1v option[value="1"]').prop('selected', true);
              } else {
              $('#kiswahili_1v').val("false");
              $('#kiswahili_1v option[value="0"]').prop('selected', true);
              }


          // Set the niveau radio button
          if (selectedClientData.niveau === 'a2') {
            $('#a2_1v').prop('checked', true);
          } else if (selectedClientData.niveau === 'licence') {
            $('#licence_1v').prop('checked', true);
          }else if (selectedClientData.niveau === '10e') {
            $('#10e_1v').prop('checked', true);
          }else if (selectedClientData.niveau === '9e') {
            $('#9e_1v').prop('checked', true);
          }


          $('#nom_avaliseur_1v').val(selectedClientData.nom_avaliseur);
          $('#prenom_avaliseur_1v').val(selectedClientData.prenom_avaliseur);
          $('#cni_avaliseur_1v').val(selectedClientData.cni_avaliseur);
          $('#telephone_avaliseur_1v').val(selectedClientData.telephone_avaliseur);
          $('#province_avaliseur_1v').val(selectedClientData.province_avaliseur);
          $('#commune_avaliseur_1v').val(selectedClientData.commune_avaliseur);
          $('#colline_avaliseur_1v').val(selectedClientData.colline_avaliseur);
          $('#lien_parente_1v').val(selectedClientData.lien_parente);
      






















      $('#printModal').modal('show');

 // Set the width of the printModal to match the A4 size
 var a4Width = 1200; // 210 mm converted to pixels
      $('#printModal').css('width', a4Width + 'px');

      // Adjust the content inside printModal to fit the A4 width
      var contentWidth = a4Width - 40; // Subtracting 40px for margins and padding
      $('.modal-content').css('width', contentWidth + 'px');

       // Center the printModal dialog
       $('#printModal').css('left', '50%');
      $('#printModal').css('top', '50%');
      $('#printModal').css('transform', 'translate(-50%, -50%)');

      // Center the modal-content
      $('.modal-content').css('position', 'relative');
      $('.modal-content').css('left', '50%');
      $('.modal-content').css('transform', 'translateX(-50%)');

    },
    error: function() {
      alert('An error occurred while fetching client data.');
    }
  });
});

/*
$(document).on('click', '#Printer', function() {
  var printContents = $('#Print_view1').html();
  var originalContents = $('body').html();

  $('body').html(printContents);

  // Access the client data from the global variable and populate the values
  $('#id_y').val(selectedClientData.id);
  $('#name_y').val(selectedClientData.name);
  $('#prenom_y').val(selectedClientData.prenom);





  // Ajouter le CSS pour enlever les bordures
  $('.pdf_style').css('border', 'none');

  window.print();
  $('body').html(originalContents);
});        */   



$(document).on('click', '#Printer', function() {
  var printContents = $('#Print_view1').html();
  var originalContents = $('body').html();

  $('body').html(printContents);

  // Inclure les feuilles de style de Bootstrap 5
  $('head').append('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');

  // Access the client data from the global variable and populate the values



  

  $('#id_1v').val(selectedClientData.id);
            $('#name_1v').val(selectedClientData.name);
            $('#prenom_1v').val(selectedClientData.prenom);

            if (selectedClientData.profile_image) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + selectedClientData.profile_image;
                $('#profile_image_1v').attr('src', imagePath);
                
                // Set image dimensions
                $('#profile_image_1v').attr('width', 180); // Remplacer par la largeur souhaitée
                $('#profile_image_1v').attr('height', 220); // Remplacer par la hauteur souhaitée
                
                $('#profile_image_1v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#profile_image_1v').attr('src', '');
                $('#profile_image_1v').removeAttr('width');
                $('#profile_image_1v').removeAttr('height');
                $('#profile_image_1v').hide();
              }


              if (selectedClientData.diplome_client) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + selectedClientData.diplome_client;
                $('#diplome_client_1v').attr('src', imagePath);
                
                // Set image dimensions
                $('#diplome_client_1v').attr('width', 450); // Remplacer par la largeur souhaitée
                $('#diplome_client_1v').attr('height', 750); // Remplacer par la hauteur souhaitée
                
                $('#diplome_client_1v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#diplome_client_1v').attr('src', '');
                $('#diplome_client_1v').removeAttr('width');
                $('#diplome_client_1v').removeAttr('height');
                $('#diplome_client_1v').hide();
              }


              if (selectedClientData.carteid_client) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + selectedClientData.carteid_client;
                $('#carteid_client_1v').attr('src', imagePath);
                
                // Set image dimensions
                $('#carteid_client_1v').attr('width', 450); // Remplacer par la largeur souhaitée
                $('#carteid_client_1v').attr('height', 750); // Remplacer par la hauteur souhaitée
                
                $('#carteid_client_1v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#carteid_client_1v').attr('src', '');
                $('#carteid_client_1v').removeAttr('width');
                $('#carteid_client_1v').removeAttr('height');
                $('#carteid_client_1v').hide();
              }



              if (selectedClientData.att_ident_compl_client) {
                // Update the image source
                var basePath = "{{ asset('storage/') }}";
                var imagePath = basePath + "/" + selectedClientData.att_ident_compl_client;
                $('#att_ident_compl_client_1v').attr('src', imagePath);
                
                // Set image dimensions
                $('#att_ident_compl_client_1v').attr('width', 450); // Remplacer par la largeur souhaitée
                $('#att_ident_compl_client_1v').attr('height', 750); // Remplacer par la hauteur souhaitée
                
                $('#att_ident_compl_client_1v').show();
              } else {
                // Clear the image source if profile_image is undefined
                $('#att_ident_compl_client_1v').attr('src', '');
                $('#att_ident_compl_client_1v').removeAttr('width');
                $('#att_ident_compl_client_1v').removeAttr('height');
                $('#att_ident_compl_client_1v').hide();
              }



    


          // Set the gender radio button
          if (selectedClientData.gender === 'male') {
            $('#male_1v').prop('checked', true);
          } else if (selectedClientData.gender === 'female') {
            $('#female_1v').prop('checked', true);
          }

          //from step 1
          $('#nom_pere_1v').val(selectedClientData.nom_pere);
          $('#prenom_pere_1v').val(selectedClientData.prenom_pere);
          $('#nom_mere_1v').val(selectedClientData.nom_mere);
          $('#prenom_mere_1v').val(selectedClientData.prenom_mere);
          $('#date_of_birth_1v').val(selectedClientData.date_of_birth);
          $('#province_1v').val(selectedClientData.province);
          $('#commune_1v').val(selectedClientData.commune);
          $('#colline_1v').val(selectedClientData.colline);
          $('#residence_actuel_1v').val(selectedClientData.residence_actuel);
          $('#nationalite_1v').val(selectedClientData.nationalite);
          $('#religion_1v').val(selectedClientData.religion);
          $('#telephone_1v').val(selectedClientData.telephone);
          $('#email_1v').val(selectedClientData.email);


          //from step 2
          $('#cni_1v').val(selectedClientData.cni);

        // Set the checkpasseport radio button
        if (selectedClientData.has_passport) {
              $('#has_passport_1v').val("true");
              $('#has_passport_1v option[value="1"]').prop('selected', true);
              } else {
              $('#has_passport_1v').val("false");
              $('#has_passport_1v option[value="0"]').prop('selected', true);
              }


          $('#passport_1v').val(selectedClientData.passport);

        // Set the checkcartejaune radio button
            if (selectedClientData.has_cartejaune) {
              $('#has_cartejaune_1v').val("true");
              $('#has_cartejaune_1v option[value="1"]').prop('selected', true);
              } else {
              $('#has_cartejaune_1v').val("false");
              $('#has_cartejaune_1v option[value="0"]').prop('selected', true);
              }





        // Set the checkpayerinscription radio button

        if (selectedClientData.has_payerinscription) {
              $('#has_payerinscription_1v').val("true");
              $('#has_payerinscription_1v option[value="1"]').prop('selected', true);
              } else {
              $('#has_payerinscription_1v').val("false");
              $('#has_payerinscription_1v option[value="0"]').prop('selected', true);
              }




          // Set the checkpermisconduire radio button
          if (selectedClientData.has_permisconduire) {
              $('#has_permisconduire_1v').val("true");
              $('#has_permisconduire_1v option[value="1"]').prop('selected', true);
              } else {
              $('#has_permisconduire_1v').val("false");
              $('#has_permisconduire_1v option[value="0"]').prop('selected', true);
              }




          $('#enfant_1v').val(selectedClientData.enfant);


          // Set the marital_status radio button
        if (selectedClientData.marital_status === 'single') {
            $('#single_1v').prop('checked', true);
          } else if (selectedClientData.marital_status === 'married') {
            $('#married_1v').prop('checked', true);
          }else if (selectedClientData.marital_status === 'divorce') {
            $('#divorce_1v').prop('checked', true);
          }


          //from step 3

              if (selectedClientData.francais) {
              $('#francais_1v').val("true");
              $('#francais_1v option[value="1"]').prop('selected', true);
              } else {
              $('#francais_1v').val("false");
              $('#francais_1v option[value="0"]').prop('selected', true);
              }

              if (selectedClientData.anglais) {
              $('#anglais_1v').val("true");
              $('#anglais_1v option[value="1"]').prop('selected', true);
              } else {
              $('#anglais_1v').val("false");
              $('#anglais_1v option[value="0"]').prop('selected', true);
              }

              if (selectedClientData.kiswahili) {
              $('#kiswahili_1v').val("true");
              $('#kiswahili_1v option[value="1"]').prop('selected', true);
              } else {
              $('#kiswahili_1v').val("false");
              $('#kiswahili_1v option[value="0"]').prop('selected', true);
              }


          // Set the niveau radio button
          if (selectedClientData.niveau === 'a2') {
            $('#a2_1v').prop('checked', true);
          } else if (selectedClientData.niveau === 'licence') {
            $('#licence_1v').prop('checked', true);
          }else if (selectedClientData.niveau === '10e') {
            $('#10e_1v').prop('checked', true);
          }else if (selectedClientData.niveau === '9e') {
            $('#9e_1v').prop('checked', true);
          }


          $('#nom_avaliseur_1v').val(selectedClientData.nom_avaliseur);
          $('#prenom_avaliseur_1v').val(selectedClientData.prenom_avaliseur);
          $('#cni_avaliseur_1v').val(selectedClientData.cni_avaliseur);
          $('#telephone_avaliseur_1v').val(selectedClientData.telephone_avaliseur);
          $('#province_avaliseur_1v').val(selectedClientData.province_avaliseur);
          $('#commune_avaliseur_1v').val(selectedClientData.commune_avaliseur);
          $('#colline_avaliseur_1v').val(selectedClientData.colline_avaliseur);
          $('#lien_parente_1v').val(selectedClientData.lien_parente);
      















  // Ajouter le CSS pour enlever les bordures

$('label').css('font-style', 'italic');
  $('.form-control').css('font-weight', 'bold');

  $('#my-heading').css({
  'font-weight': 'bold',
  'text-align': 'center'
});
  
  // Attendre que les feuilles de style de Bootstrap soient chargées
  setTimeout(function() {
    // Appliquer les classes de grille Bootstrap aux éléments
    $('.col-md-6').addClass('col-md-6');
    $('.col-md-2').addClass('col-md-2');
    $('.col-md-3').addClass('col-md-3');

    // Appliquer la largeur spécifique à la classe "col-md-6"
    $('.col-md-6').css('flex', '0 0 50%');
    $('.col-md-6').css('max-width', '50%');

    // Appliquer la largeur spécifique à la classe "col-md-2"
    $('.col-md-2').css('flex', '0 0 16.666667%');
    $('.col-md-2').css('max-width', '16.666667%');

    // Appliquer la largeur spécifique à la classe "col-md-3"
    $('.col-md-3').css('flex', '0 0 25%');
    $('.col-md-3').css('max-width', '25%');

    // Afficher le code HTML
    console.log('HTML:', printContents);

    window.print();
    $('body').html(originalContents);
  }, 1000); // Attendre 1 seconde pour que les feuilles de style soient chargées
});













var printingInitiated = false;

window.onbeforeprint = function() {
  printingInitiated = true;
};

window.onafterprint = function() {
  if (printingInitiated) {
    setTimeout(function() {
      // Return to the "result.blade.php" page after a delay
      window.location.href = '/date';
    }, 100);
  }
};

$(document).on('click', '.closepop', function() {
  $('#printModal').modal('hide');
});



function openPrintPage() {
    if (selectedClientID) {
        var printUrl = '/clients/print/' + selectedClientID + "/print";
        //url: "/clients/" + selectedClientID + "/edit", 
        window.open(printUrl, '_blank');
    }
}  











//Route::get('/clients/print/{id}', [ReportController::class, 'print'])->name('clients.print');
//Route::get('/clients/{id}/edit', [ReportController::class,'editClient'])->name('clients.edit');



////******************************************************************** */


$(document).ready(function() {
    // Lorsque le bouton "Generate PDF" est cliqué
    $('#generate_pdf').click(function(e) {
              e.preventDefault(); // Empêche le comportement par défaut du formulaire
              if (selectedClientID) {
          generatePDF(selectedClientID);
        } else {
          // Handle the case when no client is selected
          console.log("No client selected");
        }
          });
     
       function generatePDF(selectedClientID) {
        // Appel AJAX pour récupérer les données du client
        $.ajax({
          url: "/clients/" + selectedClientID + "/edit", 
            type: 'GET',
            success: function(clientData) {

              var clientData = clientData.client;
              var profileImage = clientData.profile_image;
           
            console.log(clientData.id);

                // Appel AJAX pour générer le PDF avec les données du client
                $.ajax({
                  url: '/generate-pdf/' + selectedClientID,
                  type: 'GET',
                    data: clientData,
                    headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                           },
                    xhrFields: {
                        responseType: 'blob' // Spécifie le type de réponse comme un blob
                    },
                    success: function(response) {
                        // Créer un lien de téléchargement
                        var url = window.URL.createObjectURL(response);
                        var link = document.createElement('a');
                        link.href = url;
                        link.download = 'document.pdf'; // Nom du fichier PDF à télécharger
                        link.click();

                        // Libérer l'URL de l'objet
                        window.URL.revokeObjectURL(url);

                        console.log('PDF téléchargé avec succès');
                    },
                    error: function(xhr) {
                        // Gestion des erreurs
                        console.log('Une erreur s\'est produite lors de la génération du PDF');
                    }
                });
            },
            error: function(xhr) {
                // Gestion des erreurs
                console.log('Une erreur s\'est produite lors de la récupération des données du client');
            }
        });

      }


    });

















//Route::get('/clients/{id}/update', [ReportController::class,'updateClient'])->name('clients.update');
// Function to save the modifications

// Attach a click event listener to the "Save" button
var saveBtn = document.getElementById('save-btn');
saveBtn.addEventListener('click', saveFormData);



function saveFormData() {


  var updateID = $(this).attr('id');
  // Get the form inputs

  var id = document.getElementById('id').value;
  var name = document.getElementById('name').value;
  var prenom = document.getElementById('prenom').value;
  var gender = document.querySelector('input[name="gender"]:checked').value;
  var nom_pere = document.getElementById('nom_pere').value;
  var prenom_pere = document.getElementById('prenom_pere').value;
  var nom_mere = document.getElementById('nom_mere').value;
  var prenom_mere = document.getElementById('prenom_mere').value;
  var date_of_birth = document.getElementById('date_of_birth').value;
  var province = document.getElementById('province').value;
  var commune = document.getElementById('commune').value;
  var colline = document.getElementById('colline').value;
  var residence_actuel = document.getElementById('residence_actuel').value;
  var religion = document.getElementById('religion').value;
  var nationalite = document.getElementById('nationalite').value;
  var telephone = document.getElementById('telephone').value;
  var email = document.getElementById('email').value;
  var cni = document.getElementById('cni').value;



  

  var has_passport = document.getElementById('has_passport').value;
  var passport = document.getElementById('passport').value;

  var has_cartejaune = document.getElementById('has_cartejaune').value;
  var has_payerinscription = document.getElementById('has_payerinscription').value;
  var has_permisconduire = document.getElementById('has_permisconduire').value;

  var enfant = document.getElementById('enfant').value;
  var marital_status = document.querySelector('input[name="marital_status"]:checked').value;
  
  var francais = document.getElementById('francais').value;
  var anglais = document.getElementById('anglais').value;
  var kiswahili = document.getElementById('kiswahili').value;
  var niveau = document.querySelector('input[name="niveau"]:checked').value;
  var nom_avaliseur = document.getElementById('nom_avaliseur').value;
  var prenom_avaliseur = document.getElementById('prenom_avaliseur').value;
  var cni_avaliseur = document.getElementById('cni_avaliseur').value;
  var telephone_avaliseur = document.getElementById('telephone_avaliseur').value;
  var province_avaliseur = document.getElementById('province_avaliseur').value;
  var commune_avaliseur = document.getElementById('commune_avaliseur').value;
  var colline_avaliseur = document.getElementById('colline_avaliseur').value;
  var lien_parente = document.getElementById('lien_parente').value;



/*

  var id = document.getElementById('id').value;
  var name = document.getElementById('name').value;
  var prenom = document.getElementById('prenom').value;
  var gender = document.querySelector('input[name="gender"]:checked').value;
  var dateOfBirth = document.getElementById('date_of_birth').value;
  var email = document.getElementById('email').value;
  var cni = document.getElementById('cni').value;
  var hasPayerInscription = document.querySelector('input[name="has_payerinscription"]:checked').value;
  var enfant = document.getElementById('enfant').value;
  var maritalStatus = document.querySelector('input[name="marital_status"]:checked').value;
  var francais = document.getElementById('francais').value;
                                                                  */
  // Create an object with the form data
  var formData = {

    id: id,
    name: name,
    prenom: prenom,
    gender: gender,
    nom_pere: nom_pere,
    prenom_pere: prenom_pere,
    nom_mere: nom_mere,
    prenom_mere: prenom_mere,
    date_of_birth: date_of_birth,
    province: province,
    commune: commune,
    colline: colline,
    residence_actuel: residence_actuel,
    religion: religion,
    nationalite: nationalite,
    telephone: telephone,
    email: email,
    cni: cni,
    has_passport: has_passport,
    passport: passport,
    has_cartejaune: has_cartejaune,
    has_payerinscription: has_payerinscription,
    has_permisconduire: has_permisconduire,
    enfant: enfant,
    marital_status: marital_status,
    francais: francais,
    anglais: anglais,
    kiswahili: kiswahili,
    niveau: niveau,
    nom_avaliseur: nom_avaliseur,
    prenom_avaliseur: prenom_avaliseur,
    cni_avaliseur: cni_avaliseur,
    telephone_avaliseur: telephone_avaliseur,
    province_avaliseur: province_avaliseur,
    commune_avaliseur: commune_avaliseur,
    colline_avaliseur: colline_avaliseur,
    lien_parente: lien_parente,





   /* id: id,
    name: name,
    prenom: prenom,
    gender: gender,
    date_of_birth: dateOfBirth,
    email: email,
    cni: cni,
    has_payerinscription: hasPayerInscription,
    enfant: enfant,
    marital_status: maritalStatus,
    francais: francais     */
  };

  // Send the data to the server using AJAX
  $.ajax({
    type: 'POST',
   url: "/clients/" + id + "/update", // Replace with your save route URL

    
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
    data: JSON.stringify(formData),
    contentType: 'application/json',
    success: function(response) {
      // Data saved successfully
      console.log('Data saved successfully.');
    },
    error: function(error) {
      // Error occurred while saving data
      console.error('Error saving data.');
    }
  });
}



















        // Cancel button click event handler
        $(document).on('click', '#cancel-btn', function() {
            // Show the table
            $('#order_table').show();

            // Hide the form
            $('#client-details-form').hide();
              // Hide the form
              $('#client_details_view').hide();

            // Refresh the page
            location.reload();
            });




//&&&&&&&&&&&&&&&&&&&&& gestion des pages pour la fonction edit debut  &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&


// Récupérer les boutons et les étapes du formulaire
const nextBtn1 = document.getElementById('next-btn-1');
const nextBtn2 = document.getElementById('next-btn-2');
const prevBtn2 = document.getElementById('prev-btn-2');
const prevBtn3 = document.getElementById('prev-btn-3');
const step1 = document.getElementById('step-1');
const step2 = document.getElementById('step-2');
const step3 = document.getElementById('step-3');

// Gérer le clic sur le bouton "Next" de l'étape 1
nextBtn1.addEventListener('click', () => {
  step1.style.display = 'none';
  step2.style.display = 'block';
});

// Gérer le clic sur le bouton "Next" de l'étape 2
nextBtn2.addEventListener('click', () => {
  step2.style.display = 'none';
  step3.style.display = 'block';
});

// Gérer le clic sur le bouton "Preview" de l'étape 2
prevBtn2.addEventListener('click', () => {
  step2.style.display = 'none';
  step1.style.display = 'block';
});

// Gérer le clic sur le bouton "Preview" de l'étape 3
prevBtn3.addEventListener('click', () => {
  step3.style.display = 'none';
  step2.style.display = 'block';
});

//&&&&&&&&&&&&&&&&&&&&& gestion des pages pour la fonction edit fin  &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&


//&&&&&&&&&&&&&&&&&&&&& gestion des pages pour la fonction view debut  &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

// Récupérer les boutons et les étapes du formulaire
const nextBtn1_v = document.getElementById('next-btn-1_v');
const nextBtn2_v = document.getElementById('next-btn-2_v');
const nextBtn3_v = document.getElementById('next-btn-3_v');
const nextBtn4_v = document.getElementById('next-btn-4_v');
const nextBtn5_v = document.getElementById('next-btn-5_v');
const prevBtn2_v = document.getElementById('prev-btn-2_v');
const prevBtn3_v = document.getElementById('prev-btn-3_v');
const prevBtn4_v = document.getElementById('prev-btn-4_v');
const prevBtn5_v = document.getElementById('prev-btn-5_v');
const prevBtn6_v = document.getElementById('prev-btn-6_v');
const step1_v = document.getElementById('step-1_v');
const step2_v = document.getElementById('step-2_v');
const step3_v= document.getElementById('step-3_v');
const step4_v= document.getElementById('step-4_v');
const step5_v= document.getElementById('step-5_v');
const step6_v= document.getElementById('step-6_v');

// Gérer le clic sur le bouton "Next" de l'étape 1
nextBtn1_v.addEventListener('click', () => {
  step1_v.style.display = 'none';
  step2_v.style.display = 'block';
});

// Gérer le clic sur le bouton "Next" de l'étape 2
nextBtn2_v.addEventListener('click', () => {
  step2_v.style.display = 'none';
  step3_v.style.display = 'block';
});

// Gérer le clic sur le bouton "Next" de l'étape 3
nextBtn3_v.addEventListener('click', () => {
  step3_v.style.display = 'none';
  step4_v.style.display = 'block';
});

// Gérer le clic sur le bouton "Next" de l'étape 4
nextBtn4_v.addEventListener('click', () => {
  step4_v.style.display = 'none';
  step5_v.style.display = 'block';
});

// Gérer le clic sur le bouton "Next" de l'étape 5
nextBtn5_v.addEventListener('click', () => {
  step5_v.style.display = 'none';
  step6_v.style.display = 'block';
});

// Gérer le clic sur le bouton "Preview" de l'étape 2
prevBtn2_v.addEventListener('click', () => {
  step2_v.style.display = 'none';
  step1_v.style.display = 'block';
});

// Gérer le clic sur le bouton "Preview" de l'étape 3
prevBtn3_v.addEventListener('click', () => {
  step3_v.style.display = 'none';
  step2_v.style.display = 'block';
});

// Gérer le clic sur le bouton "Preview" de l'étape 4
prevBtn4_v.addEventListener('click', () => {
  step4_v.style.display = 'none';
  step3_v.style.display = 'block';
});

// Gérer le clic sur le bouton "Preview" de l'étape 5
prevBtn5_v.addEventListener('click', () => {
  step5_v.style.display = 'none';
  step4_v.style.display = 'block';
});

// Gérer le clic sur le bouton "Preview" de l'étape 6
prevBtn6_v.addEventListener('click', () => {
  step6_v.style.display = 'none';
  step5_v.style.display = 'block';
});



//&&&&&&&&&&&&&&&&&&&&& gestion des pages pour la fonction view fin  &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&


// ----------------------------------------------------------------------------
//--------------------------------assigeti---------------------------------------------





$("#fetchval").on('change', function(){
    var selectedValue = $(this).val();
   // alert(value);

   $('#order_table').DataTable({
    "bDestroy": true,
   ajax: {
   // type: 'GET',
    url:'{{ route("/date") }}',
    data:{selectedValue:selectedValue},
   },
   
   columns: [
            {data: 'name', name: 'name'},
            {data: 'prenom', name: 'prenom'},
            {data: 'telephone', name: 'telephone'},
            {data:'email',name:'email'},
            {data:'created_at',name:'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false},
    
    ],
    "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
    "pageLength": 10,
    "searching": false
  }).fnDestroy();
});


     
// ----------------------------------------------------------------------------
//-----------------------------------------------------------------------------




 var user_id;
  
  $(document).on('click', '.delete', function(){
      user_id = $(this).attr('id');
      $('#confirmModal').modal('show');
  });


  $('#ok_button').click(function(){
        $.ajax({
            url:"users/destroy/"+user_id,
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                $('#confirmModal').modal('hide');
                $('#user_table').DataTable().ajax.reload();
                alert('Data Deleted');
                }, 2000);
            }
        })
    });

    /*
    $(document).on('click', '#bulk_delete', function(){
        var id = [];
        if(confirm("Êtes-vous sûr de vouloir envoyer ces données ?"))
        {
            $('.users_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            if(id.length > 0)
            {
                
                $.ajax({

                    url:"{{ route('/date')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:"get",
                    data:{E_Signature:E_Signature},    
                    
                    beforeSend: function(){
                        $('#loader').show();
                    },

                    success:function(data)
                    {
                        
                        console.log(data);
                        alert(data.msg);
                      //  alert(data.message);
                        //alert("factures bien envoyer dans OBR");
                        window.location.assign("/date"); 
                    },
                    complete: function(){
                        $('#loader').hide();
                    },
                    error: function(xhr, status, error) {
                       // var errors = data.responseJSON;
                       // console.log(errors);
                     //  console.log(data);
                      // alert("une erreur est survenue lors de l'envoi");
                     // console.log(errors);
                     // alert(errors.file);
                     alert(xhr.responseText);
                       window.location.assign("/date"); 
                    }
                });
            }
            else
            {
                alert("Veuillez cocher au moins une case");
                window.location.assign("/date"); 
            }
        }
    });

    */


 $('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  if(from_date != '' &&  to_date != '')
  {
   $('#order_table').DataTable().destroy();
   load_data(from_date, to_date);
  }
  else
  {
   alert('Les deux dates sont requises');
  }
 });

 $('#refresh').click(function(){
  $('#from_date').val('');
  $('#to_date').val('');
  $('#order_table').DataTable().destroy();
  load_data();
 });

});
</script>
@endsection   

