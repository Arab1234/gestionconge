<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Jourferie;
use App\Models\Permission;
use App\Models\Planification;
use App\Models\Service;
use App\Models\Typeconge;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Translation\Provider\NullProvider;

class GestionConges extends Controller
{
    //Autres

    function getConnectedService()
    {
        return head(DB::select("select * from services where idCS=?",[Auth::user()->id]));
    }

    //Page Congés Administratifs
    function getCA()
    {
        $Planifications = Planification::all()->where("IdUser", '=', Auth::user()->id)->where("Année", '=', Carbon::now()->year);
        $Congés = DB::select('select conges.*,typeconges.Libelle from typeconges,conges where typeconges.id = conges.IdType and IdUser=?', [Auth::user()->id]);
        $Types = Typeconge::all();
        return view('conges', ['Planifications' => $Planifications, 'Congés' => $Congés, 'Types' => $Types,'Service'=>$this->getConnectedService()]);
    }

    function getCP()
    {
        $Planifications = Planification::all()->where("IdUser", '=', Auth::user()->id)->where("Année", '=', Carbon::now()->year);
        $Congés = DB::select('select conges.*,typeconges.Libelle from typeconges,conges where typeconges.id = conges.IdType and IdUser=?', [Auth::user()->id]);
        $Types = Typeconge::all();
        $Permissions=Permission::all();
        return view('Permissions', ['Planifications' => $Planifications, 'Congés' => $Congés, 'Types' => $Types,'Service'=>$this->getConnectedService(),"Permissions"=>$Permissions]);
    }

    function newPlan(Request $request)
    {
        $DateDébut1 = $request->input("DateDébut1");
        $DateFin1 = $request->input("DateFin1");
        $DateDébut2 = $request->input("DateDébut2");
        $DateFin2 = $request->input("DateFin2");
        $DateDébut3 = $request->input("DateDébut3");
        $DateFin3 = $request->input("DateFin3");
        $Planification = new Planification();
        $Planification->Année = Carbon::now()->year;
        $Planification->DateDébut1 = $DateDébut1;
        $Planification->DateFin1 = $DateFin1;
        $Planification->DateDébut2 = $DateDébut2;
        $Planification->DateFin2 = $DateFin2;
        $Planification->DateDébut3 = $DateDébut3;
        $Planification->DateFin3 = $DateFin3;
        $Planification->IdUser = Auth::user()->id;
        $Planification->save();
        return back()->with("msg", "Demande Effectuée");
    }

    function UpPlan(Request $request)
    {
        $DateDébut1 = $request->input("DateDébut1");
        $DateFin1 = $request->input("DateFin1");
        $DateDébut2 = $request->input("DateDébut2");
        $DateFin2 = $request->input("DateFin2");
        $DateDébut3 = $request->input("DateDébut3");
        $DateFin3 = $request->input("DateFin3");
        $Planification = Planification::all()->where("id", "=", $request->input("id"))->first();
        $Planification->DateDébut1 = $DateDébut1;
        $Planification->DateFin1 = $DateFin1;
        $Planification->DateDébut2 = $DateDébut2;
        $Planification->DateFin2 = $DateFin2;
        $Planification->DateDébut3 = $DateDébut3;
        $Planification->DateFin3 = $DateFin3;
        $Planification->save();
        return back()->with("msg", "Demande Modifiée");
    }

    function DelPlan(Request $request)
    {
        $Planification = Planification::all()->where("id", "=", $request->input("id"))->first();
        $Planification->delete();
        return back()->with("msg", "Demande Supprimée");
    }

    //---------------------------------------------------------------

    function newCongé(Request $request)
    {
        if(Auth::user()->nbTotal==0)
        return back()->with("msg", "Solde de congé insuffisant");
        $DateDébut = $request->input("DateDébut");
        $Type = $request->input("Type");
        $NbJour = $request->input("nbJour");
        if($Type != 4)
        {
            $dt=Carbon::createFromFormat('Y-m-d', $DateDébut);
            $dt->addDays($NbJour);

            CarbonPeriod::macro('countWeekdays', function () {
                return $this->filter('isWeekday');
            });
            $NbJour = count(array_merge(CarbonPeriod::create($DateDébut, $dt)->countWeekdays()->toArray()));
        }
        
        if ($Type == 1) {
            $Congé = new Conge();
            $Congé->DateDébut = $DateDébut;
            $Congé->IdType = $Type;
            $Congé->nbJour = $NbJour;
            $Congé->IdPlan = Planification::all()->where("IdUser", '=', Auth::user()->id)->where("Année", '=', Carbon::now()->year)->first()->id;
            $Congé->IdUser = Auth::user()->id;
            $Congé->save();
        } else {
            $Congé = new Conge();
            $Congé->DateDébut = $DateDébut;
            $Congé->IdType = $Type;
            $Congé->nbJour = $NbJour;
            $Congé->IdUser = Auth::user()->id;
            $Congé->save();
        }

        return back()->with("msg", "Demande Effectuée");
    }

    function UpCongé(Request $request)
    {
        $DateDébut = $request->input("DateDébut");
        $NbJour = $request->input("nbJour");
        $Congé = Conge::all()->where("id","=",$request->input("id"))->first();
        $Congé->DateDébut = $DateDébut;
        $Congé->nbJour = $NbJour;
        $Congé->save();
        return back()->with("msg", "Demande Modifiée");
    }

    function DelCongé(Request $request)
    {
        $Congé = Conge::all()->where("id", "=", $request->input("id"))->first();
        $Congé->delete();
        return back()->with("msg", "Demande Supprimée");
    }
    //Page Gestion Plannings
    function getGP()
    {
        if($this->getConnectedService()==null)
            return $this->getCA();
        if(Auth::user()->IdService==2)
            $Planifications=DB::select('select planifications.*,users.Nom,users.Prénom,services.Libelle from users,planifications,services where planifications.IdUser = users.id and users.IdService=services.id and planifications.Année=?', [Carbon::now()->year]);
        else
            $Planifications=DB::select('select planifications.*,users.Nom,users.Prénom,services.Libelle from users,planifications,services where planifications.IdUser = users.id and users.IdService=services.id and services.id=? and planifications.Année=?', [$this->getConnectedService()->id,Carbon::now()->year]);
            
                return view('GPlanings', ['Planifications' => $Planifications,'Service'=>$this->getConnectedService()]);
    }

    function ValPlan(Request $request)
    {
        $CS=DB::select("select * from services where idCS=?",[Auth::user()->id]);
        if(count($CS)>0)
        {
            $IdS=User::all()->where("id","=",Planification::all()->where("id","=",$request->input('id'))->first()->IdUser)->first()->IdService;
            if(head($CS)->id==2 && $IdS==2)
            {
                $Planification=Planification::all()->where("id",'=',$request->input('id'))->first();
                $Planification->VRH=1;
                $Planification->VCS=1;
                $Planification->save();
                

            }
            else
            if(head($CS)->id==2)
            {
                $Planification=Planification::all()->where("id",'=',$request->input('id'))->first();
                $Planification->VRH=1;
                $Planification->save();
                
            }
            else
            {
                $Planification=Planification::all()->where("id",'=',$request->input('id'))->first();
                $Planification->VCS=1;
                $Planification->save();
            }
            
        }
        return back()->with("msg", "Demande Validée");
    }

    function RefPlan(Request $request)
    {
        $CS=DB::select("select * from services where idCS=?",[Auth::user()->id]);
        if(count($CS)>0)
        {
            $IdS=User::all()->where("id","=",Planification::all()->where("id","=",$request->input('id'))->first()->IdUser)->first()->IdService;
            if(head($CS)->id==2 && $IdS==2)
            {
                $Planification=Planification::all()->where("id",'=',$request->input('id'))->first();
                $Planification->VRH = -1;
                $Planification->VCS = -1;
                $Planification->save();
            }
            else
            if(head($CS)->id==2)
            {
                $Planification=Planification::all()->where("id",'=',$request->input('id'))->first();
                $Planification->VRH = -1;
                $Planification->save();
            }
            else
            {
                $Planification=Planification::all()->where("id",'=',$request->input('id'))->first();
                $Planification->VCS = -1;
                $Planification->save();
            }
            
        }
        return back()->with("msg", "Demande Refusée");
    }

        //Page Gestion Congés
        function getGC()
        {
            if($this->getConnectedService()==null)
                return $this->getCA();

        if(Auth::user()->IdService==2)
            $Congés=DB::select('select conges.*,users.Nom,users.Prénom,services.Libelle,typeconges.Libelle as Type from users,conges,services,typeconges where conges.IdUser = users.id and users.IdService=services.id and conges.IdType=typeconges.id and typeconges.id<>3', []);
        else
        $Congés=DB::select('select conges.*,users.Nom,users.Prénom,services.Libelle,typeconges.Libelle as Type from users,conges,services,typeconges where conges.IdUser = users.id and users.IdService=services.id and conges.IdType=typeconges.id and typeconges.id<>3 and services.id=?', [$this->getConnectedService()->id]);
            
            
            return view('GCongés', ['Congés' => $Congés,'Service'=>$this->getConnectedService()]);
        }
    
        function ValCongé(Request $request)
        {
            $CS=DB::select("select * from services where idCS=?",[Auth::user()->id]);
            if(count($CS)>0)
            {
                $IdS=User::all()->where("id","=",Conge::all()->where("id","=",$request->input('id'))->first()->IdUser)->first()->IdService;
                if(head($CS)->id==2 && $IdS==2)
                {
                    $Congé=Conge::all()->where("id",'=',$request->input('id'))->first();
                    $Congé->VRH=1;
                    $Congé->VCS=1;
                    $Congé->save();
                    if($Congé->IdType!=4 && $Congé->IdType!=3)
                    {
                        $myuser=User::all()->where("id","=",Conge::all()->where("id","=",$request->input('id'))->first()->IdUser)->first();
                        $myuser->nbTotal=$myuser->nbTotal-$Congé->nbJour;
                        $myuser->save();
                    }
                    
    
                }
                else
                if(head($CS)->id==2)
                {
                    $Congé=Conge::all()->where("id",'=',$request->input('id'))->first();
                    $Congé->VRH=1;
                    $Congé->save();
                    if($Congé->IdType!=4 && $Congé->IdType!=3)
                    {
                    $myuser=User::all()->where("id","=",Conge::all()->where("id","=",$request->input('id'))->first()->IdUser)->first();
                    $myuser->nbTotal=$myuser->nbTotal-$Congé->nbJour;
                    $myuser->save();
                    }
                }
                else
                {
                    $Congé=Conge::all()->where("id",'=',$request->input('id'))->first();
                    $Congé->VCS=1;
                    $Congé->save();
                }
                
            }
            return back()->with("msg", "Demande Validée");
        }
    
        function RefCongé(Request $request)
        {
            $CS=DB::select("select * from services where idCS=?",[Auth::user()->id]);
            if(count($CS)>0)
            {
                $IdS=User::all()->where("id","=",Conge::all()->where("id","=",$request->input('id'))->first()->IdUser)->first()->IdService;
                if(head($CS)->id==2 && $IdS==2)
                {
                    $Congé=Conge::all()->where("id",'=',$request->input('id'))->first();
                    $Congé->VRH = -1;
                    $Congé->VCS = -1;
                    $Congé->save();
                }
                else
                if(head($CS)->id==2)
                {
                    $Congé=Conge::all()->where("id",'=',$request->input('id'))->first();
                    $Congé->VRH = -1;
                    $Congé->save();
                }
                else
                {
                    $Congé=Conge::all()->where("id",'=',$request->input('id'))->first();
                    $Congé->VCS = -1;
                    $Congé->save();
                }
                
            }
            return back()->with("msg", "Demande Refusée");
        }

    //Page Gestion Congés Maladie
    function getGCM()
    {
        if($this->getConnectedService()==null)
            return $this->getCA();
        $Congés=DB::select('select conges.*,users.Nom,users.Prénom,services.Libelle,typeconges.Libelle as Type from users,conges,services,typeconges where conges.IdUser = users.id and users.IdService=services.id and conges.IdType=typeconges.id and typeconges.id=3', []);
        return view('GcongesM', ['Congés' => $Congés,'Service'=>$this->getConnectedService(),"Users"=>User::all()]);
    }

    function newCongéM(Request $request)
    {
        $DateDébut = $request->input("DateDébut");
        $Type = 3;
        $NbJour = $request->input("nbJour");
        
            $Congé = new Conge();
            $Congé->DateDébut = $DateDébut;
            $Congé->IdType = $Type;
            $Congé->nbJour = $NbJour;
            $Congé->IdUser = $request->input("Employé");
            $Congé->VRH = -2;
            $Congé->VCS = -2;
            $Congé->save();

        return back()->with("msg", "Congé ajouté");
    }

    function DelCongéM(Request $request)
    {
        $Congé = Conge::all()->where("id", "=", $request->input("id"))->first();
        $Congé->delete();
        return back()->with("msg", "Congé Supprimé");
    }

}
