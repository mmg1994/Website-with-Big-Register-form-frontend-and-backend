<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('prenom');
            $table->enum('gender', ['male', 'female']);
            $table->string('nom_pere');
            $table->string('prenom_pere');
            $table->string('nom_mere');
            $table->string('prenom_mere');
            $table->date('date_of_birth');
            $table->string('province');
            $table->string('commune');
            $table->string('colline');
            $table->string('residence_actuel');
            $table->string('nationalite');
            $table->string('religion');
            $table->string('telephone');
            $table->string('email')->unique();
            $table->string('cni');
            
            $table->boolean('has_passport')->default(false);
            $table->string('passport')->nullable();
            
            $table->boolean('has_cartejaune')->default(false);
            $table->boolean('has_payerinscription')->default(false);
            $table->boolean('has_permisconduire')->default(false);
            
            $table->string('enfant');
            
            $table->enum('marital_status', ['single', 'married' , 'divorce']);
            $table->boolean('francais')->default(false);
            $table->boolean('anglais')->default(false);
            $table->boolean('kiswahili')->default(false);
            
            $table->enum('niveau', ['a2','licence', '10e', '9e']);
                        
            $table->string('nom_avaliseur');
            $table->string('prenom_avaliseur');
            $table->string('cni_avaliseur');
            $table->string('telephone_avaliseur');
            $table->string('province_avaliseur');
            $table->string('commune_avaliseur');
            $table->string('colline_avaliseur');
            $table->string('lien_parente');
                        
            $table->string('profile_image')->nullable();
            $table->string('diplome_client')->nullable();
            $table->string('carteid_client')->nullable();
            $table->string('att_ident_compl_client')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved');
    }
}
