@extends('Master.master')

@section('gcm-active', 'active')

@section('content')
<div class="card">
    <div class="card-header">Congés</div>
    <div class="card-body">
        <div class="table-responsive" style="max-height: 200px;">
            <table class="table table-stripped table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="vertical-align : middle;text-align:center;">Employé</th>
                        <th style="vertical-align : middle;text-align:center;">Service</th>
                        <th style="vertical-align : middle;text-align:center;">Date Début</th>
                        <th style="vertical-align : middle;text-align:center;">Nombre des jours</th>
                        <th style="vertical-align : middle;text-align:center;">Type</th>
                        <th style="vertical-align : middle;text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Congés as $item)
                        <tr>
                            <td>{{ $item->Nom }} {{ $item->Prénom }}</td>
                            <td>{{ $item->Libelle }}</td>
                            <td>{{ $item->DateDébut }}</td>
                            <td>{{ $item->nbJour }}</td>
                            <td>{{ $item->Type }}</td>
                            <td>
                                
                                        <form action="{{ route('DelCongéM') }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method("post") <button type="submit" class="btn" name="id"
                                                value="{{ $item->id }}">
                                                <li class="fa fa-trash text-danger"></li>
                                            </button>
                                            </form>
                            </td>
                        </tr>
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
                <form action="{{ route('newCongéM') }}" method="POST">
                    @csrf
                    @method("post")

                    <div class="form-group">
                        <label for="Employé">Employé</label>
                        <select name="Employé" id="Employé" class="form-control">
                            @foreach ($Users as $user)
                                
                                <option value="{{ $user->id }}">{{ $user->Nom }} {{ $user->Prénom }}</option>
                                       
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
@endsection