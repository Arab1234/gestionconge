<?php

use App\Http\Controllers\GestionConges;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Authentification

Route::get('/Login',function(){
    //return Hash::make("Mehach@2022");
    //return Hash::make("Aitmessaoud@2022");
    //return Hash::make("Lasfar@2022");
    return view("login");
})->name("login");

Route::post('/Login',function(Request $rq){
    $credentials = $rq->only('email', 'password');
        if($rq->input('remember-me')!==null)
        {
            if (Auth::attempt($credentials,$remember=true)) {
                // Authentication passed...
                return redirect()->intended(route('CA'));
                }
                else
                {
                    return redirect()->back()->with('msg','Utilisateur / mot de passe incorrect');
                }
        }else
        {
            if (Auth::attempt($credentials,$remember=false)) {
                // Authentication passed...
                return redirect()->intended(route('CA'));
                }
                else
                {
                    return redirect()->back()->with('msg','Utilisateur / mot de passe incorrect');
                }
        }
})->name("login");

Route::get("/logout",function(){
    Auth::logout();
    return back();
})->name("logout");

//Page Congés Administratifs
Route::get('/', [GestionConges::class,'getCA'])->name("CA")->middleware("auth");
Route::get('/Permissions', [GestionConges::class,'getCP'])->name("CP")->middleware("auth");

Route::post('/Conges/Planification/Add',[GestionConges::class,'newPlan'])->name("AddPlan")->middleware("auth");

Route::post('/Conges/Planification/Up',[GestionConges::class,'UpPlan'])->name("UpPlan")->middleware("auth");

Route::post('/Conges/Planification/Del',[GestionConges::class,'DelPlan'])->name("DelPlan")->middleware("auth");

//-----------------------------------------------------

Route::post('/Conges/Congé/Add',[GestionConges::class,'newCongé'])->name("AddCongé")->middleware("auth");

Route::post('/Conges/Congé/Up',[GestionConges::class,'UpCongé'])->name("UpCongé")->middleware("auth");

Route::post('/Conges/Congé/Del',[GestionConges::class,'DelCongé'])->name("DelCongé")->middleware("auth");

//Page Gestion Plannings

Route::get('/Gestion/Plannings', [GestionConges::class,'getGP'])->name("GP")->middleware("auth");

Route::post('/Gestion/Plannings/Val',[GestionConges::class,'ValPlan'])->name("ValPlan")->middleware("auth");

Route::post('/Gestion/Plannings/Ref',[GestionConges::class,'RefPlan'])->name("RefPlan")->middleware("auth");

//Page Gestion Congés

Route::get('/Gestion/Congés', [GestionConges::class,'getGC'])->name("GDC")->middleware("auth");

Route::post('/Gestion/Congés/Val',[GestionConges::class,'ValCongé'])->name("ValCongé")->middleware("auth");

Route::post('/Gestion/Congés/Ref',[GestionConges::class,'RefCongé'])->name("RefCongé")->middleware("auth");

//Page Gestion Congés Maladie

Route::get('/Gestion/Congés/Maladie', [GestionConges::class,'getGCM'])->name("GCM")->middleware("auth");

Route::post('/Gestion/Congés/Maladie/add',[GestionConges::class,'newCongéM'])->name("newCongéM")->middleware("auth");

Route::post('/Gestion/Congés/Maladie/del',[GestionConges::class,'DelCongéM'])->name("DelCongéM")->middleware("auth");

// Generate PDF
Route::get("GeneratePDF/{id}",function ($id) {

    // retreive all records from db
    $data = DB::select('select users.CIN,conges.DateDébut,typeconges.Libelle,conges.nbJour,users.Nom,users.Prénom from users,conges,typeconges where conges.IdUser=users.id and conges.IdType=typeconges.id and conges.id=?', [$id]);
    // share data to view
    //return view('reporting.Décision',["data"=>$data[0]]);
    View()->share('reporting.Décision',["data"=>$data[0]]);
    $pdf = PDF::loadView('reporting.Décision',["data"=>$data[0]]);
    // download PDF file with download method
    return $pdf->download('Décision.pdf');
  })->name("gen")->middleware("auth");
