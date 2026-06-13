@extends('Master.master')

@section('ca-active', 'active')

@section('content')
    <div class="card">
        <div class="card-header">Planifications</div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 200px;">
                <table class="table table-stripped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align : middle;text-align:center;">Année</th>
                            <th colspan="2" style="vertical-align : middle;text-align:center;">Période 1</th>
                            <th colspan="2" style="vertical-align : middle;text-align:center;">Période 2</th>
                            <th colspan="2" style="vertical-align : middle;text-align:center;">Période 3</th>
                            <th rowspan="2" style="vertical-align : middle;text-align:center;">Etat</th>
                            <th rowspan="2" style="vertical-align : middle;text-align:center;">Actions</th>
                        </tr>
                        <tr>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Planifications as $item)
                            <tr>
                                <td>{{ $item->Année }}</td>
                                <td>{{ $item->DateDébut1 }}</td>
                                <td>{{ $item->DateFin1 }}</td>
                                <td>{{ $item->DateDébut2 }}</td>
                                <td>{{ $item->DateFin2 }}</td>
                                <td>{{ $item->DateDébut3 }}</td>
                                <td>{{ $item->DateFin3 }}</td>
                                <td>
                                    @if ($item->VCS == 0)
                                        <span class="text-warning">En cours</span><br>
                                    @endif
                                    @if ($item->VCS == 1)
                                        <span class="text-info">Validé (CS)</span><br>
                                    @endif
                                    @if ($item->VRH == 1)
                                        <span class="text-success">Validé (RH)</span><br>
                                    @endif
                                    @if ($item->VCS == -1)
                                        <span class="text-danger">Refusé (CS)</span><br>
                                    @endif
                                    @if ($item->VRH == -1)
                                        <span class="text-danger">Refusé (RH)</span><br>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->VCS == 0 && $item->VRH == 0)
                                        <a href="#" data-toggle="modal" data-target="#mdlUpPlan{{ $item->id }}">
                                            <li class="fa fa-pen"></li>
                                        </a>
                                        <form action="{{ route('DelPlan') }}" method="POST" style="display: inline;">@csrf
                                            @method("post") <button type="submit" class="btn" name="id"
                                                value="{{ $item->id }}">
                                                <li class="fa fa-trash text-danger"></li>
                                            </button></form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        @if ($Planifications->count() <= 0)
            <div class="card-footer">
                <div class="text-center"><button class="btn btn-primary" data-toggle="modal"
                        data-target="#mdlAddPlan">Nouvelle Planification</button></div>
            </div>
        @endif

    </div>

    <br>

    <div class="card">
        <div class="card-header">Congés</div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 200px;">
                <table class="table table-stripped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style="vertical-align : middle;text-align:center;">Date Début</th>
                            <th style="vertical-align : middle;text-align:center;">Nombre des jours</th>
                            <th style="vertical-align : middle;text-align:center;">Type</th>
                            <th style="vertical-align : middle;text-align:center;">Etat</th>
                            <th style="vertical-align : middle;text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Congés as $item)
                            @if ($item->IdType != 3 && $item->IdType != 4)
                                <tr>
                                    <td>{{ $item->DateDébut }}</td>
                                    <td>{{ $item->nbJour }}</td>
                                    <td>{{ $item->Libelle }}</td>
                                    <td>
                                        @if ($item->VCS == 0)
                                            <span class="text-warning">En cours</span><br>
                                        @endif
                                        @if ($item->VCS == 1)
                                            <span class="text-info">Validé (CS)</span><br>
                                        @endif
                                        @if ($item->VRH == 1)
                                            <span class="text-success">Validé (RH)</span><br>
                                        @endif
                                        @if ($item->VCS == -1)
                                            <span class="text-danger">Refusé (CS)</span><br>
                                        @endif
                                        @if ($item->VRH == -1)
                                            <span class="text-danger">Refusé (RH)</span><br>
                                        @endif
                                    </td>



                                    <td>
                                        @if ($item->VCS == 0)
                                            @if ($item->VCS == 0 && $item->VRH == 0)
                                                <form action="{{ route('DelCongé') }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method("post") <button type="submit" class="btn" name="id"
                                                        value="{{ $item->id }}">
                                                        <li class="fa fa-trash text-danger"></li>
                                                    </button></form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center"><button class="btn btn-primary" data-toggle="modal"
                    data-target="#mdlAddCongé">Nouveau Congé</button></div>
        </div>

    </div>

    <br>

    <div class="card">
        <div class="card-header">Congés Maladie</div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 200px;">
                <table class="table table-stripped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style="vertical-align : middle;text-align:center;">Date Début</th>
                            <th style="vertical-align : middle;text-align:center;">Nombre des jours</th>
                            <th style="vertical-align : middle;text-align:center;">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Congés as $item)
                            @if ($item->IdType == 3)
                                <tr>
                                    <td>{{ $item->DateDébut }}</td>
                                    <td>{{ $item->nbJour }}</td>
                                    <td>{{ $item->Libelle }}</td>

                                </tr>
                            @endif

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <!-- Modal add congé -->
    <div class="modal fade" id="mdlAddCongé">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nouveau Congé</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('AddCongé') }}" method="POST">
                        @csrf
                        @method("post")

                        <div class="form-group">
                            <label for="Type">Type de congé</label>
                            <select name="Type" id="Type" class="form-control">
                                @foreach ($Types as $type)
                                    @if ($type->id != 3 && $type->id != 4)
                                        @if ($type->id == 1)
                                            @if ($Planifications->count() > 0)
                                                @if ($Planifications->first()->VCS == 1 && $Planifications->first()->VRH == 1)
                                                    <option value="{{ $type->id }}">{{ $type->Libelle }}</option>
                                                @endif
                                            @endif
                                        @else
                                            <option value="{{ $type->id }}">{{ $type->Libelle }}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="DateDébut">Date Début</label>
                            <input type="date" class="form-control" id="DateDébut" name="DateDébut" />
                        </div>

                        <div class="form-group">
                            <label for="nbJour">Nombre des jours</label>
                            <input type="number" class="form-control" id="nbJour" name="nbJour" />
                        </div>

                        <div class="text-center"><input type="submit" value="Valider" class="btn btn-primary" /></div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </div>

            </div>
        </div>
    </div>



    <!-- Modal add planification -->
    <div class="modal fade" id="mdlAddPlan">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nouvelle Planification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('AddPlan') }}" method="POST">
                        @csrf
                        @method("post")
                        <div class="row">
                            <div class="col-md">
                                <div class="text-center">
                                    <h3>Période 1</h3>
                                </div>
                                <div class="form-group">
                                    <label for="DateDébut1">Date Début</label>
                                    <input type="date" id="DateDébut1" name="DateDébut1"
                                        min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label for="DateFin1">Date Fin</label>
                                    <input type="date" id="DateFin1" name="DateFin1"
                                        min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                        required />
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="text-center">
                                    <h3>Période 2</h3>
                                </div>
                                <div class="form-group">
                                    <label for="DateDébut2">Date Début</label>
                                    <input type="date" id="DateDébut2" name="DateDébut2"
                                        min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label for="DateFin2">Date Fin</label>
                                    <input type="date" id="DateFin2" name="DateFin2"
                                        min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                        required />
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="text-center">
                                    <h3>Période 3</h3>
                                </div>
                                <div class="form-group">
                                    <label for="DateDébut3">Date Début</label>
                                    <input type="date" id="DateDébut3" name="DateDébut3"
                                        min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="DateFin3">Date Fin</label>
                                    <input type="date" id="DateFin3" name="DateFin3"
                                        min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="text-center"><input type="submit" value="Valider" class="btn btn-primary" /></div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal update planification -->
    @foreach ($Planifications as $item)
        <div class="modal fade" id="mdlUpPlan{{ $item->id }}">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modification d'une planification</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ route('UpPlan') }}" method="POST">
                            @csrf
                            @method("post")
                            <div class="row">
                                <div class="col-md">
                                    <div class="text-center">
                                        <h3>Période 1</h3>
                                    </div>
                                    <div class="form-group">
                                        <label for="DateDébut1">Date Début</label>
                                        <input type="date" id="DateDébut1" name="DateDébut1"
                                            min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                            required value="{{ $item->DateDébut1 }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="DateFin1">Date Fin</label>
                                        <input type="date" id="DateFin1" name="DateFin1"
                                            min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                            required value="{{ $item->DateFin1 }}" />
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="text-center">
                                        <h3>Période 2</h3>
                                    </div>
                                    <div class="form-group">
                                        <label for="DateDébut2">Date Début</label>
                                        <input type="date" id="DateDébut2" name="DateDébut2"
                                            min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                            required value="{{ $item->DateDébut2 }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="DateFin2">Date Fin</label>
                                        <input type="date" id="DateFin2" name="DateFin2"
                                            min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                            required value="{{ $item->DateFin2 }}" />
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="text-center">
                                        <h3>Période 3</h3>
                                    </div>
                                    <div class="form-group">
                                        <label for="DateDébut3">Date Début</label>
                                        <input type="date" id="DateDébut3" name="DateDébut3"
                                            min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                            value="{{ $item->DateDébut3 }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="DateFin3">Date Fin</label>
                                        <input type="date" id="DateFin3" name="DateFin3"
                                            min="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                            value="{{ $item->DateFin3 }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="text-center"><button type="submit" class="btn btn-primary" name="id"
                                    value="{{ $item->id }}">Valider</button></div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
    <script>
        $("#Type").change(() => {
            $("#DateDébut").attr("min", "");
            $("#nbJour").attr("min", "");
            $("#nbJour").attr("max", "");
            $("#nbJour").prop("readonly", false);
            $("#DateDébut").prop("readonly", false);
            $("#nbJour").val("0");
            breakme: if ($("#Type").val() == 1) {
                @if ($Planifications->count() > 0)
                    @foreach ($Congés as $item)
                        @if ($item->VCS == 1 && $item->VRH == 1)
                            @if ($item->DateDébut != $Planifications->first()->DateDébut1)
                                $("#DateDébut").val("{{ $Planifications->first()->DateDébut1 }}");
                                $("#nbJour").attr("min","0");
                                $("#nbJour").attr("max","{{ Auth::user()->nbTotal }}");
                                $("#nbJour").prop("readonly",true);
                                $("#DateDébut").prop("readonly",true);
                                $("#nbJour").val("{{ (new DateTime($Planifications->first()->DateDébut1))->diff(new DateTime($Planifications->first()->DateFin1))->format('%a') -Auth::user()->nbTotal <=0? (new DateTime($Planifications->first()->DateDébut1))->diff(new DateTime($Planifications->first()->DateFin1))->format('%a'): Auth::user()->nbTotal }}");
                            @elseif ($item->DateDébut != $Planifications->first()->DateDébut2)
                                $("#DateDébut").val("{{ $Planifications->first()->DateDébut2 }}");
                                $("#nbJour").attr("min","0");
                                $("#nbJour").attr("max","{{ Auth::user()->nbTotal }}");
                                $("#nbJour").prop("readonly",true);
                                $("#DateDébut").prop("readonly",true);
                                $("#nbJour").val("{{ (new DateTime($Planifications->first()->DateDébut2))->diff(new DateTime($Planifications->first()->DateFin2))->format('%a') -Auth::user()->nbTotal <=0? (new DateTime($Planifications->first()->DateDébut2))->diff(new DateTime($Planifications->first()->DateFin2))->format('%a'): Auth::user()->nbTotal }}");
                            @elseif($item->DateDébut != $Planifications->first()->DateDébut3)
                                $("#DateDébut").val("{{ $Planifications->first()->DateDébut3 }}");
                                $("#nbJour").attr("min","0");
                                $("#nbJour").attr("max","{{ Auth::user()->nbTotal }}");
                                $("#nbJour").prop("readonly",true);
                                $("#DateDébut").prop("readonly",true);
                                $("#nbJour").val("{{ (new DateTime($Planifications->first()->DateDébut3))->diff(new DateTime($Planifications->first()->DateFin3))->format('%a') -Auth::user()->nbTotal <=0? (new DateTime($Planifications->first()->DateDébut3))->diff(new DateTime($Planifications->first()->DateFin3))->format('%a'): Auth::user()->nbTotal }}");
                            @endif

                        @endif
                    @endforeach
                    /*
                    @if (date_create($Planifications->first()->DateFin1) >= date_create(Carbon\Carbon::now()->toDateString()))
                        $("#DateDébut").val("{{ $Planifications->first()->DateDébut1 }}");
                        $("#nbJour").attr("min","0");
                        $("#nbJour").attr("max","{{ Auth::user()->nbTotal }}");
                        $("#nbJour").prop("readonly",true);
                        $("#DateDébut").prop("readonly",true);
                        $("#nbJour").val("{{ (new DateTime($Planifications->first()->DateDébut1))->diff(new DateTime($Planifications->first()->DateFin1))->format('%a') -Auth::user()->nbTotal <=0? (new DateTime($Planifications->first()->DateDébut1))->diff(new DateTime($Planifications->first()->DateFin1))->format('%a'): Auth::user()->nbTotal }}");
                        break breakme;
                    @endif
                    @if (date_create($Planifications->first()->DateFin2) >= date_create(Carbon\Carbon::now()->toDateString()))
                        $("#DateDébut").val("{{ $Planifications->first()->DateDébut2 }}");
                        $("#nbJour").attr("min","0");
                        $("#nbJour").attr("max","{{ Auth::user()->nbTotal }}");
                        $("#nbJour").prop("readonly",true);
                        $("#DateDébut").prop("readonly",true);
                        $("#nbJour").val("{{ (new DateTime($Planifications->first()->DateDébut2))->diff(new DateTime($Planifications->first()->DateFin2))->format('%a') -Auth::user()->nbTotal <=0? (new DateTime($Planifications->first()->DateDébut2))->diff(new DateTime($Planifications->first()->DateFin2))->format('%a'): Auth::user()->nbTotal }}");
                        break breakme;
                    @endif
                    @if (date_create($Planifications->first()->DateFin3) >= date_create(Carbon\Carbon::now()->toDateString()))
                        $("#DateDébut").val("{{ $Planifications->first()->DateDébut3 }}");
                        $("#nbJour").attr("min","0");
                        $("#nbJour").attr("max","{{ Auth::user()->nbTotal }}");
                        $("#nbJour").prop("readonly",true);
                        $("#DateDébut").prop("readonly",true);
                        $("#nbJour").val("{{ (new DateTime($Planifications->first()->DateDébut3))->diff(new DateTime($Planifications->first()->DateFin3))->format('%a') -Auth::user()->nbTotal <=0? (new DateTime($Planifications->first()->DateDébut3))->diff(new DateTime($Planifications->first()->DateFin3))->format('%a'): Auth::user()->nbTotal }}");
                        break breakme;
                    @endif
                */
                @endif
            }
            else if ($("#Type").val() == 2) {
                $("#DateDébut").attr("min", "{{ Carbon\Carbon::now()->toDateString() }}");
                $("#nbJour").attr("min", "0");
                @if (Auth::user()->nbTotal >= 3)
                    $("#nbJour").attr("max", "3");
                @else
                    $("#nbJour").attr("max", "{{ Auth::user()->nbTotal }}");
                @endif

                $("#nbJour").prop("readonly", false);
                $("#DateDébut").prop("readonly", false);
            }
        });
        $(document).ready(() => {
            $("#Type").change();
        })
    </script>
@endsection
