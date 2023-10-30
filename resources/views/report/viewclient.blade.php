<div id="client_details_view" style="display: none; border: 3px solid #7f7d82; width: 80%; padding: 20px;">

<div id="step-1_v">

    <div class="row">



          <div class="col-md-12">
        <div class="form-group">
          <label for="">Image:</label>
          <div style="border: 5px solid black; width: 200px; height: 250px; padding: 5px;">
            <img src="" alt="Image View" class="img-responsive" id="profile_image_v">
          </div>
        </div>
      </div>

      

   


    <div class="col-md-6">
            <div class="form-group">

              <label for="id_v">id:</label>
              <input type="text" class="form-control" id="id_v" readonly>
            
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="name_v">name:</label>
              <input type="text" class="form-control" id="name_v" readonly>
            
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              
              <label for="prenom_v">prenom:</label>
              <input type="text" class="form-control" id="prenom_v" readonly>
          
            </div>
          </div>

          
          <div class="col-md-12 text-center">
            <div class="form-group">
              <label>Gender:</label>
              <div class="gender-container">

                <input type="radio" id="male_v" name="gender_v" value="male" disabled>
                <label for="male">Male</label>
                <input type="radio" id="female_v" name="gender_v" value="female" disabled>
                <label for="female">Female</label>

              </div>
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="nom_pere_v">nom_pere:</label>
              <input type="text" class="form-control" id="nom_pere_v" readonly>
          
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="prenom_pere_v">prenom_pere:</label>
              <input type="text" class="form-control" id="prenom_pere_v" readonly>
          
            </div>
          </div>

          
          <div class="col-md-6">
            <div class="form-group">

              <label for="nom_mere_v">nom_mere:</label>
              <input type="text" class="form-control" id="nom_mere_v" readonly>
            
            </div>
          </div>

              
          <div class="col-md-6">
            <div class="form-group">

              <label for="prenom_mere_v">prenom_mere:</label>
              <input type="text" class="form-control" id="prenom_mere_v" readonly>
            
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="date_of_birth_v">date_of_birth:</label>
              <input type="date" class="form-control" id="date_of_birth_v" readonly>
            
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="province_v">province:</label>
              <input type="text" class="form-control" id="province_v" readonly>
            
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="commune_v">commune:</label>
              <input type="text" class="form-control" id="commune_v" readonly>
            
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">

              <label for="colline_v">colline:</label>
              <input type="text" class="form-control" id="colline_v" readonly>
            
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="residence_actuel_v">residence_actuel:</label>
              <input type="text" class="form-control" id="residence_actuel_v" readonly>
            
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="nationalite_v">nationalite:</label>
              <input type="text" class="form-control" id="nationalite_v" readonly>
            
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="religion_v">religion:</label>
              <input type="text" class="form-control" id="religion_v" readonly>
            
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">

              <label for="telephone_v">telephone:</label>
              <input type="text" class="form-control" id="telephone_v" readonly>
            
            </div>
          </div>


            <div class="col-md-6">
                <div class="form-group">
                  
                  <label for="email_v">Email:</label>
                  <input type="text" class="form-control" id="email_v" readonly>
                </div>
            


      
          
                <div class="d-flex justify-content-end">

                    <div class="form-group">
                      <button type="next-btn-1_v" id="next-btn-1_v" class="btn btn-primary mb-2">Next</button>
                    </div>
              
                    <div class="col-md-6">
                        <div class="form-group">
                          <button type="cancel-btn" id="cancel-btn" class="btn btn-primary">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

      </div>


  </div>

  <div id="step-2_v" style="display: none;">


        <div class="row">

  
          
          <div class="col-md-3">
                  <div class="form-group">

                  <label for="has_passport_v">has_passport:</label>
                  <select id="has_passport_v" disabled>
                    <option value="1">oui</option>
                    <option value="0">non</option>
                  </select>
                  
                  </div>
                </div>


          <div class="col-md-12">
            <div class="form-group">

              <label for="passport_v">passport:</label>
              <input type="text" class="form-control" id="passport_v" readonly>
          
            </div>
          </div>


              <div class="col-md-2">
                  <div class="form-group">

                  <label for="has_cartejaune_v">has_cartejaune:</label>
                  <select id="has_cartejaune_v" disabled>
                    <option value="1">oui</option>
                    <option value="0">non</option>
                  </select>
                  
                  </div>
                </div>


                <div class="col-md-3">
                  <div class="form-group">

                  <label for="has_payerinscription_v">has_payerinscription:</label>
                  <select id="has_payerinscription_v" disabled>
                    <option value="1">oui</option>
                    <option value="0">non</option>
                  </select>
                  
                  </div>
                </div>


                <div class="col-md-3">
                  <div class="form-group">

                  <label for="has_permisconduire_v">has_permisconduire:</label>
                  <select id="has_permisconduire_v" disabled>
                    <option value="1">oui</option>
                    <option value="0">non</option>
                  </select>
                  
                  </div>
                </div>

                

            <div class="col-md-6">
            <div class="form-group">

              <label for="cni_v">cni:</label>
              <input type="text" class="form-control" id="cni_v" readonly>
            
            </div>
          </div>



          <div class="col-md-6">
            <div class="form-group">

              <label for="enfant_v">enfant:</label>
              <input type="text" class="form-control" id="enfant_v" readonly>
            
            </div>
          </div>


        
          <div class="col-md-12 text-center">
            <div class="form-group">
              <label>marital_status:</label>
              <div class="gender-container">

                <input type="radio" id="single_v" name="marital_status_v" value="single" disabled>
                <label for="non">single</label>
                <input type="radio" id="married_v" name="marital_status_v" value="married" disabled>
                <label for="oui">married</label>
                <input type="radio" id="divorce_v" name="marital_status_v" value="divorce" disabled>
                <label for="oui">divorce</label>


              </div>
            </div>
          </div>




              <div class="col-md-3">
                <div class="form-group">

                <button type="prev-btn-2_v" id="prev-btn-2_v" class="btn btn-primary mb-2">Preview</button>

                </div>
              </div>



              <div class="col-md-3">
                <div class="form-group">

                <button type="next-btn-2_v" id="next-btn-2_v" class="btn btn-primary mb-2">Next</button>

                </div>
              </div>


              <div class="col-md-3">
                <div class="form-group">

                <button type="cancel-btn" id="cancel-btn" class="btn btn-primary">Cancel</button>

                </div>
              </div>

        </div>


  </div>


  <div id="step-3_v" style="display: none;">

      <div class="row">




                    
            <div class="col-md-3">
                  <div class="form-group">

                  <label for="francais_v">francais:</label>
                  <select id="francais_v" disabled>
                    <option value="1">oui</option>
                    <option value="0">non</option>
                  </select>
                  
                  </div>
                </div>


                <div class="col-md-3">
                  <div class="form-group">

                  <label for="anglais_v">anglais:</label>
                  <select id="anglais_v" disabled>
                    <option value="1">oui</option>
                    <option value="0">non</option>
                  </select>
                  
                  </div>
                </div>


                <div class="col-md-3">
                  <div class="form-group">

                  <label for="kiswahili_v">kiswahili:</label>
                  <select id="kiswahili_v" disabled>
                    <option value="1">oui</option>
                    <option value="0">non</option>
                  </select>
                  
                  </div>
                </div>



 
                <div class="col-md-12 text-center">
                  <div class="form-group">
                    <label>niveau:</label>
                    <div class="gender-container">

                      <input type="radio" id="a2_v" name="niveau_v" value="a2" disabled>
                      <label for="non">a2</label>
                      <input type="radio" id="licence_v" name="niveau_v" value="licence" disabled>
                      <label for="oui">licence</label>
                      <input type="radio" id="10e_v" name="niveau_v" value="10e" disabled>
                      <label for="oui">10e</label>
                      <input type="radio" id="9e_v" name="niveau_v" value="9e" disabled>
                      <label for="oui">9e</label>
                     
                    </div>
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">

                    <label for="nom_avaliseur_v">nom_avaliseur:</label>
                    <input type="text" class="form-control" id="nom_avaliseur_v" readonly>
                  
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">

                    <label for="prenom_avaliseur_v">prenom_avaliseur:</label>
                    <input type="text" class="form-control" id="prenom_avaliseur_v" readonly>
                  
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">

                    <label for="cni_avaliseur_v">cni_avaliseur:</label>
                    <input type="text" class="form-control" id="cni_avaliseur_v" readonly>
                  
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">

                    <label for="telephone_avaliseur_v">telephone_avaliseur:</label>
                    <input type="text" class="form-control" id="telephone_avaliseur_v" readonly>
                  
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">

                    <label for="province_avaliseur_v">province_avaliseur:</label>
                    <input type="text" class="form-control" id="province_avaliseur_v" readonly>
                  
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">

                    <label for="commune_avaliseur_v">commune_avaliseur:</label>
                    <input type="text" class="form-control" id="commune_avaliseur_v" readonly>
                  
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">

                    <label for="colline_avaliseur_v">colline_avaliseur:</label>
                    <input type="text" class="form-control" id="colline_avaliseur_v" readonly>
                  
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">

                    <label for="lien_parente_v">lien_parente:</label>
                    <input type="text" class="form-control" id="lien_parente_v" readonly>
                  
                  </div>
                </div>


                <div class="col-md-3">
                <div class="form-group">

                <button type="prev-btn-3_v" id="prev-btn-3_v" class="btn btn-primary mb-2">Preview</button>

                </div>
              </div>


              <div class="col-md-3">
                <div class="form-group">

                <button type="next-btn-3_v" id="next-btn-3_v" class="btn btn-primary mb-2">Next</button>

                </div>
              </div>



              <div class="col-md-3">
                <div class="form-group">

                <button type="cancel-btn" id="cancel-btn" class="btn btn-primary">Cancel</button>

                </div>
              </div>


      </div>
  
  </div>



    <div id="step-4_v" style="display: none;">


      <div class="row">




              <div class="col-md-12">
          <div class="form-group">
            <label for="">diplome client:</label>
            <div style="border: 5px solid black; width: 500px; height: 800px; padding: 5px;">
              <embed src="" type="application/pdf" width="100%" height="100%"  id="diplome_client_v" />
            </div>
          </div>
        </div>


      <div class="col-md-3">
                <div class="form-group">

                <button type="prev-btn-4_v" id="prev-btn-4_v" class="btn btn-primary mb-2">Preview</button>

                </div>
              </div>


              
           <div class="col-md-3">
                <div class="form-group">

                <button type="next-btn-4_v" id="next-btn-4_v" class="btn btn-primary mb-2">Next</button>

                </div>
              </div>


              <div class="col-md-3">
                <div class="form-group">

                <button type="cancel-btn" id="cancel-btn" class="btn btn-primary">Cancel</button>

                </div>
              </div>



        

      </div>


    </div>





    <div id="step-5_v" style="display: none;">


  <div class="row">




        <div class="col-md-12">
    <div class="form-group">
      <label for="">carte identite client:</label>
      <div style="border: 5px solid black; width: 500px; height: 800px; padding: 5px;">
        <embed src="" type="application/pdf" width="100%" height="100%"  id="carteid_client_v" />
      </div>
    </div>
  </div>


<div class="col-md-3">
          <div class="form-group">

          <button type="prev-btn-5_v" id="prev-btn-5_v" class="btn btn-primary mb-2">Preview</button>

          </div>
        </div>


        
     <div class="col-md-3">
          <div class="form-group">

          <button type="next-btn-5_v" id="next-btn-5_v" class="btn btn-primary mb-2">Next</button>

          </div>
        </div>


        <div class="col-md-3">
          <div class="form-group">

          <button type="cancel-btn" id="cancel-btn" class="btn btn-primary">Cancel</button>

          </div>
        </div>



  

</div>


</div>




    <div id="step-6_v" style="display: none;">


  <div class="row">




        <div class="col-md-12">
          <div class="form-group">
            <label for="">attestation identite complete des client:</label>
            <div style="border: 5px solid black; width: 500px; height: 800px; padding: 5px;">
              <embed src="" type="application/pdf" width="100%" height="100%"  id="att_ident_compl_client_v" />
            </div>
          </div>
        </div>


      <div class="col-md-3">
          <div class="form-group">

          <button type="prev-btn-6_v" id="prev-btn-6_v" class="btn btn-primary mb-2">Preview</button>

          </div>
        </div>



        <div class="col-md-3">
          <div class="form-group">

          <button type="cancel-btn" id="cancel-btn" class="btn btn-primary">Cancel</button>

          </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
            <button type="submit" id="Print" class="btn btn-primary">Print</button>
            </div>
          </div>
  

    </div>


    </div>


</div>

