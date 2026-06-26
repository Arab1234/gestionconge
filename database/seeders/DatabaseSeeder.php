<?php

namespace Database\Seeders;

use App\Models\Conge;
use App\Models\Permission;
use App\Models\Planification;
use App\Models\Service;
use App\Models\Typeconge;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ---------------------------------------------------------------
        // 1. LEAVE TYPES  (IDs are referenced in the controller by number)
        // ---------------------------------------------------------------
        Typeconge::insert([
            ['Libelle' => 'Congé Annuel',        'created_at' => now(), 'updated_at' => now()], // id 1
            ['Libelle' => 'Congé Administratif', 'created_at' => now(), 'updated_at' => now()], // id 2
            ['Libelle' => 'Congé Maladie',       'created_at' => now(), 'updated_at' => now()], // id 3
            ['Libelle' => 'Congé Exceptionnel',  'created_at' => now(), 'updated_at' => now()], // id 4
        ]);

        // ---------------------------------------------------------------
        // 2. PERMISSIONS  (short-leave authorization types)
        // ---------------------------------------------------------------
        Permission::insert([
            ['Libelle' => 'Autorisation 1/2 journée',      'nbJour' => 1],
            ['Libelle' => 'Autorisation 1 jour',            'nbJour' => 1],
            ['Libelle' => 'Mariage (employé)',              'nbJour' => 4],
            ['Libelle' => 'Mariage (enfant)',               'nbJour' => 2],
            ['Libelle' => 'Naissance',                      'nbJour' => 3],
            ['Libelle' => 'Décès (conjoint / enfant)',      'nbJour' => 3],
            ['Libelle' => 'Décès (parent / frère / sœur)', 'nbJour' => 3],
            ['Libelle' => 'Circoncision',                   'nbJour' => 2],
            ['Libelle' => 'Pèlerinage (Hajj)',              'nbJour' => 26],
        ]);

        // ---------------------------------------------------------------
        // 3. SERVICES  (created without IdCS to avoid circular FK)
        // ---------------------------------------------------------------

        // id=1 — Informatique
        $serviceIT = Service::create(['Abr' => 'IT',  'Libelle' => 'Informatique',        'IdCS' => null]);
        // id=2 — RH (IMPORTANT: controller checks IdService == 2 for admin access)
        $serviceRH = Service::create(['Abr' => 'RH',  'Libelle' => 'Ressources Humaines', 'IdCS' => null]);
        // id=3 — Comptabilité
        $serviceCPT = Service::create(['Abr' => 'CPT', 'Libelle' => 'Comptabilité',       'IdCS' => null]);

        // ---------------------------------------------------------------
        // 4. USERS
        // ---------------------------------------------------------------

        // --- RH Admin (full access, Chef of RH) ---
        $adminRH = User::create([
            'Matricule' => 'RH001',
            'Nom'       => 'Benali',
            'Prénom'    => 'Yasmine',
            'Adresse'   => 'Siège Social, Casablanca',
            'NumTel'    => '0600000001',
            'CIN'       => 'AA100001',
            'nbTotal'   => 22,
            'IdService' => $serviceRH->id,
            'email'     => 'admin@gestionconge.com',
            'password'  => Hash::make('password'),
        ]);
        $serviceRH->update(['IdCS' => $adminRH->id]);

        // --- Chef de Service — Informatique ---
        $chefIT = User::create([
            'Matricule' => 'IT001',
            'Nom'       => 'Moussaoui',
            'Prénom'    => 'Karim',
            'Adresse'   => '5 Avenue Hassan II, Rabat',
            'NumTel'    => '0661001001',
            'CIN'       => 'BE200001',
            'nbTotal'   => 22,
            'IdService' => $serviceIT->id,
            'email'     => 'chef.it@gestionconge.com',
            'password'  => Hash::make('password'),
        ]);
        $serviceIT->update(['IdCS' => $chefIT->id]);

        // --- Chef de Service — Comptabilité ---
        $chefCPT = User::create([
            'Matricule' => 'CPT001',
            'Nom'       => 'Tahiri',
            'Prénom'    => 'Nadia',
            'Adresse'   => '18 Rue Ibn Batouta, Fès',
            'NumTel'    => '0662002002',
            'CIN'       => 'CD300001',
            'nbTotal'   => 22,
            'IdService' => $serviceCPT->id,
            'email'     => 'chef.cpt@gestionconge.com',
            'password'  => Hash::make('password'),
        ]);
        $serviceCPT->update(['IdCS' => $chefCPT->id]);

        // --- Employee 1 — IT department ---
        $emp1 = User::create([
            'Matricule' => 'IT002',
            'Nom'       => 'Alaoui',
            'Prénom'    => 'Mehdi',
            'Adresse'   => '22 Rue Allal El Fassi, Rabat',
            'NumTel'    => '0670100100',
            'CIN'       => 'BE400001',
            'nbTotal'   => 22,
            'IdService' => $serviceIT->id,
            'email'     => 'mehdi.alaoui@gestionconge.com',
            'password'  => Hash::make('password'),
        ]);

        // --- Employee 2 — IT department ---
        $emp2 = User::create([
            'Matricule' => 'IT003',
            'Nom'       => 'Cherkaoui',
            'Prénom'    => 'Sara',
            'Adresse'   => '7 Boulevard Zerktouni, Casablanca',
            'NumTel'    => '0670200200',
            'CIN'       => 'BE400002',
            'nbTotal'   => 18,
            'IdService' => $serviceIT->id,
            'email'     => 'sara.cherkaoui@gestionconge.com',
            'password'  => Hash::make('password'),
        ]);

        // --- Employee 3 — Comptabilité department ---
        $emp3 = User::create([
            'Matricule' => 'CPT002',
            'Nom'       => 'Raissouni',
            'Prénom'    => 'Omar',
            'Adresse'   => '3 Rue de la Liberté, Meknès',
            'NumTel'    => '0670300300',
            'CIN'       => 'CD400001',
            'nbTotal'   => 20,
            'IdService' => $serviceCPT->id,
            'email'     => 'omar.raissouni@gestionconge.com',
            'password'  => Hash::make('password'),
        ]);

        // ---------------------------------------------------------------
        // 5. ANNUAL LEAVE PLANS (planifications) for current year
        // ---------------------------------------------------------------

        // Employee 1 — plan approved by CS and RH
        $plan1 = Planification::create([
            'Année'      => now()->year,
            'DateDébut1' => now()->year . '-07-01',
            'DateFin1'   => now()->year . '-07-15',
            'DateDébut2' => now()->year . '-12-20',
            'DateFin2'   => now()->year . '-12-31',
            'DateDébut3' => null,
            'DateFin3'   => null,
            'VCS'        => 1,
            'VRH'        => 1,
            'IdUser'     => $emp1->id,
        ]);

        // Employee 2 — plan approved by CS, pending RH
        $plan2 = Planification::create([
            'Année'      => now()->year,
            'DateDébut1' => now()->year . '-08-01',
            'DateFin1'   => now()->year . '-08-20',
            'DateDébut2' => now()->year . '-11-01',
            'DateFin2'   => now()->year . '-11-10',
            'DateDébut3' => null,
            'DateFin3'   => null,
            'VCS'        => 1,
            'VRH'        => 0,
            'IdUser'     => $emp2->id,
        ]);

        // Employee 3 — plan pending both
        $plan3 = Planification::create([
            'Année'      => now()->year,
            'DateDébut1' => now()->year . '-09-01',
            'DateFin1'   => now()->year . '-09-14',
            'DateDébut2' => now()->year . '-01-02',
            'DateFin2'   => now()->year . '-01-10',
            'DateDébut3' => null,
            'DateFin3'   => null,
            'VCS'        => 0,
            'VRH'        => 0,
            'IdUser'     => $emp3->id,
        ]);

        // Chef IT — plan approved
        Planification::create([
            'Année'      => now()->year,
            'DateDébut1' => now()->year . '-07-15',
            'DateFin1'   => now()->year . '-07-31',
            'DateDébut2' => now()->year . '-12-01',
            'DateFin2'   => now()->year . '-12-15',
            'DateDébut3' => null,
            'DateFin3'   => null,
            'VCS'        => 1,
            'VRH'        => 1,
            'IdUser'     => $chefIT->id,
        ]);

        // ---------------------------------------------------------------
        // 6. LEAVE REQUESTS (conges)
        // ---------------------------------------------------------------

        // Employee 1 — annual leave, linked to plan, fully approved
        Conge::create([
            'DateDébut' => now()->year . '-07-01',
            'nbJour'    => 10,
            'VCS'       => 1,
            'VRH'       => 1,
            'IdType'    => 1, // Congé Annuel
            'IdPlan'    => $plan1->id,
            'IdUser'    => $emp1->id,
        ]);

        // Employee 1 — administrative leave, pending
        Conge::create([
            'DateDébut' => now()->year . '-09-05',
            'nbJour'    => 2,
            'VCS'       => 0,
            'VRH'       => 0,
            'IdType'    => 2, // Congé Administratif
            'IdPlan'    => null,
            'IdUser'    => $emp1->id,
        ]);

        // Employee 2 — annual leave, approved by CS, pending RH
        Conge::create([
            'DateDébut' => now()->year . '-08-01',
            'nbJour'    => 15,
            'VCS'       => 1,
            'VRH'       => 0,
            'IdType'    => 1, // Congé Annuel
            'IdPlan'    => $plan2->id,
            'IdUser'    => $emp2->id,
        ]);

        // Employee 2 — exceptional leave, rejected by CS
        Conge::create([
            'DateDébut' => now()->year . '-05-10',
            'nbJour'    => 4,
            'VCS'       => -1,
            'VRH'       => 0,
            'IdType'    => 4, // Congé Exceptionnel
            'IdPlan'    => null,
            'IdUser'    => $emp2->id,
        ]);

        // Employee 3 — annual leave, pending both
        Conge::create([
            'DateDébut' => now()->year . '-09-01',
            'nbJour'    => 10,
            'VCS'       => 0,
            'VRH'       => 0,
            'IdType'    => 1, // Congé Annuel
            'IdPlan'    => $plan3->id,
            'IdUser'    => $emp3->id,
        ]);

        // Employee 3 — sick leave added directly by RH
        Conge::create([
            'DateDébut' => now()->year . '-03-15',
            'nbJour'    => 5,
            'VCS'       => -2,
            'VRH'       => -2,
            'IdType'    => 3, // Congé Maladie
            'IdPlan'    => null,
            'IdUser'    => $emp3->id,
        ]);

        // Chef IT — exceptional leave, fully approved
        Conge::create([
            'DateDébut' => now()->year . '-04-20',
            'nbJour'    => 3,
            'VCS'       => 1,
            'VRH'       => 1,
            'IdType'    => 4, // Congé Exceptionnel
            'IdPlan'    => null,
            'IdUser'    => $chefIT->id,
        ]);
    }
}

