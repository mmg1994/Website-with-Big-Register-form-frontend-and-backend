    <style>
        .pdf_style {
         border: none;
        }

        
        #my-heading {
  text-align: center;
}
        h1 {
            text-align: center;
        }

        #printModal {
            width: 794px; /* 210 mm converted to pixels */
          /*  height: 1123px;  297 mm converted to pixels */
          position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
        }

        </style>



<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="printModalLabel">Print</h5>
        <button type="button" class="closepop" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   
      <div id="Print_view" >
        <div id="Print_view1"  >
 
            <!-- **********************************************************   -->
   
        <h1 id="my-heading">LES INFORMATIONS DU CLIENT</h1>
    




        <div class="row">



                    <div class="col-md-12">
                    <div class="form-group">
                    <label for="">Image:</label>
                    <div style="border: 5px solid black; width: 200px; height: 250px; padding: 5px;">
                    <img src="" alt="Image View" class="img-responsive" id="profile_image_1v">
                    </div>
                    </div>
                    </div>



                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="id_v">id:</label>
                        <input type="text" class="form-control" id="id_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="name_v">name:</label>
                        <input type="text" class="form-control" id="name_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">
                        
                        <label for="prenom_v">prenom:</label>
                        <input type="text" class="form-control" id="prenom_1v" readonly>

                    </div>
                    </div>


                    <div class="col-md-12 text-center">
                    <div class="form-group">
                        <label>Gender:</label>
                        <div class="gender-container">

                        <input type="radio" id="male_1v" name="gender_1v" value="male" disabled>
                        <label for="male">Male</label>
                        <input type="radio" id="female_1v" name="gender_1v" value="female" disabled>
                        <label for="female">Female</label>

                        </div>
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="nom_pere_1v">nom_pere:</label>
                        <input type="text" class="form-control" id="nom_pere_1v" readonly>

                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="prenom_pere_1v">prenom_pere:</label>
                        <input type="text" class="form-control" id="prenom_pere_1v" readonly>

                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="nom_mere_1v">nom_mere:</label>
                        <input type="text" class="form-control" id="nom_mere_1v" readonly>
                    
                    </div>
                    </div>

                        
                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="prenom_mere_1v">prenom_mere:</label>
                        <input type="text" class="form-control" id="prenom_mere_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="date_of_birth_1v">date_of_birth:</label>
                        <input type="date" class="form-control" id="date_of_birth_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="province_1v">province:</label>
                        <input type="text" class="form-control" id="province_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="commune_1v">commune:</label>
                        <input type="text" class="form-control" id="commune_1v" readonly>
                    
                    </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="colline_1v">colline:</label>
                        <input type="text" class="form-control" id="colline_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="residence_actuel_1v">residence_actuel:</label>
                        <input type="text" class="form-control" id="residence_actuel_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="nationalite_1v">nationalite:</label>
                        <input type="text" class="form-control" id="nationalite_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="religion_1v">religion:</label>
                        <input type="text" class="form-control" id="religion_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="telephone_1v">telephone:</label>
                        <input type="text" class="form-control" id="telephone_1v" readonly>
                    
                    </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            
                            <label for="email_1v">Email:</label>
                            <input type="text" class="form-control" id="email_1v" readonly>
                        </div>
                    




                    </div>

                    </div>
























                    <div class="row">

                    
                            
                    <div class="col-md-3">
                            <div class="form-group">

                            <label for="has_passport_1v">has_passport:</label>
                            <select id="has_passport_1v" disabled>
                            <option value="1">oui</option>
                            <option value="0">non</option>
                            </select>
                            
                            </div>
                        </div>


                    <div class="col-md-12">
                    <div class="form-group">

                        <label for="passport_1v">passport:</label>
                        <input type="text" class="form-control" id="passport_1v" readonly>

                    </div>
                    </div>


                        <div class="col-md-2">
                            <div class="form-group">

                            <label for="has_cartejaune_1v">has_cartejaune:</label>
                            <select id="has_cartejaune_1v" disabled>
                            <option value="1">oui</option>
                            <option value="0">non</option>
                            </select>
                            
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">

                            <label for="has_payerinscription_1v">has_payerinscription:</label>
                            <select id="has_payerinscription_1v" disabled>
                            <option value="1">oui</option>
                            <option value="0">non</option>
                            </select>
                            
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">

                            <label for="has_permisconduire_1v">has_permisconduire:</label>
                            <select id="has_permisconduire_1v" disabled>
                            <option value="1">oui</option>
                            <option value="0">non</option>
                            </select>
                            
                            </div>
                        </div>

                        

                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="cni_1v">cni:</label>
                        <input type="text" class="form-control" id="cni_1v" readonly>
                    
                    </div>
                    </div>



                    <div class="col-md-6">
                    <div class="form-group">

                        <label for="enfant_1v">enfant:</label>
                        <input type="text" class="form-control" id="enfant_1v" readonly>
                    
                    </div>
                    </div>



                    <div class="col-md-12 text-center">
                    <div class="form-group">
                        <label>marital_status:</label>
                        <div class="gender-container">

                        <input type="radio" id="single_1v" name="marital_status_1v" value="single" disabled>
                        <label for="non">single</label>
                        <input type="radio" id="married_1v" name="marital_status_1v" value="married" disabled>
                        <label for="oui">married</label>
                        <input type="radio" id="divorce_1v" name="marital_status_1v" value="divorce" disabled>
                        <label for="oui">divorce</label>


                        </div>
                    </div>
                    </div>




                    </div>
























                    <div class="row">




                                        
                    <div class="col-md-3">
                        <div class="form-group">

                        <label for="francais_1v">francais:</label>
                        <select id="francais_1v" disabled>
                            <option value="1">oui</option>
                            <option value="0">non</option>
                        </select>
                        
                        </div>
                        </div>


                        <div class="col-md-3">
                        <div class="form-group">

                        <label for="anglais_1v">anglais:</label>
                        <select id="anglais_1v" disabled>
                            <option value="1">oui</option>
                            <option value="0">non</option>
                        </select>
                        
                        </div>
                        </div>


                        <div class="col-md-3">
                        <div class="form-group">

                        <label for="kiswahili_1v">kiswahili:</label>
                        <select id="kiswahili_1v" disabled>
                            <option value="1">oui</option>
                            <option value="0">non</option>
                        </select>
                        
                        </div>
                        </div>




                        <div class="col-md-12 text-center">
                        <div class="form-group">
                            <label>niveau:</label>
                            <div class="gender-container">

                            <input type="radio" id="a2_1v" name="niveau_1v" value="a2" disabled>
                            <label for="non">a2</label>
                            <input type="radio" id="licence_1v" name="niveau_1v" value="licence" disabled>
                            <label for="oui">licence</label>
                            <input type="radio" id="10e_1v" name="niveau_1v" value="10e" disabled>
                            <label for="oui">10e</label>
                            <input type="radio" id="9e_1v" name="niveau_1v" value="9e" disabled>
                            <label for="oui">9e</label>
                            
                            </div>
                        </div>
                        </div>


                        <div class="col-md-6">
                        <div class="form-group">

                            <label for="nom_avaliseur_1v">nom_avaliseur:</label>
                            <input type="text" class="form-control" id="nom_avaliseur_1v" readonly>
                        
                        </div>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">

                            <label for="prenom_avaliseur_1v">prenom_avaliseur:</label>
                            <input type="text" class="form-control" id="prenom_avaliseur_1v" readonly>
                        
                        </div>
                        </div>


                        <div class="col-md-6">
                        <div class="form-group">

                            <label for="cni_avaliseur_1v">cni_avaliseur:</label>
                            <input type="text" class="form-control" id="cni_avaliseur_1v" readonly>
                        
                        </div>
                        </div>


                        <div class="col-md-6">
                        <div class="form-group">

                            <label for="telephone_avaliseur_1v">telephone_avaliseur:</label>
                            <input type="text" class="form-control" id="telephone_avaliseur_1v" readonly>
                        
                        </div>
                        </div>


                        <div class="col-md-6">
                        <div class="form-group">

                            <label for="province_avaliseur_1v">province_avaliseur:</label>
                            <input type="text" class="form-control" id="province_avaliseur_1v" readonly>
                        
                        </div>
                        </div>


                        <div class="col-md-6">
                        <div class="form-group">

                            <label for="commune_avaliseur_1v">commune_avaliseur:</label>
                            <input type="text" class="form-control" id="commune_avaliseur_1v" readonly>
                        
                        </div>
                        </div>


                        <div class="col-md-6">
                        <div class="form-group">

                            <label for="colline_avaliseur_1v">colline_avaliseur:</label>
                            <input type="text" class="form-control" id="colline_avaliseur_1v" readonly>
                        
                        </div>
                        </div>


                        <div class="col-md-6">
                        <div class="form-group">

                            <label for="lien_parente_1v">lien_parente:</label>
                            <input type="text" class="form-control" id="lien_parente_1v" readonly>
                        
                        </div>
                        </div>



                    </div>









<!--





                    <div class="row">




                    <div class="col-md-12">
                    <div class="form-group">
                    <label for="">diplome client:</label>
                    <div style="border: 5px solid black; width: 500px; height: 800px; padding: 5px;">
                    <embed src="" type="application/pdf" width="100%" height="100%"  id="diplome_client_1v" />
                    </div>
                    </div>
                    </div>






                    </div>



















                    <div class="row">




                    <div class="col-md-12">
                    <div class="form-group">
                    <label for="">carte identite client:</label>
                    <div style="border: 5px solid black; width: 500px; height: 800px; padding: 5px;">
                    <embed src="" type="application/pdf" width="100%" height="100%"  id="carteid_client_1v" />
                    </div>
                    </div>
                    </div>







                    </div>



























                    <div class="row">




                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="">attestation identite complete des client:</label>
                                <div style="border: 5px solid black; width: 500px; height: 800px; padding: 5px;">
                                <embed src="" type="application/pdf" width="100%" height="100%"  id="att_ident_compl_client_1v" />
                                </div>
                            </div>
                            </div>



                        </div>




    -->












                <!-- **********************************************************   -->


    </div>
         <button id="Printer">Printdd</button>
    </div>

    </div>
    </div>
  </div>
</div>