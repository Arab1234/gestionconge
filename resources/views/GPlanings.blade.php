@extends('Master.master')

@section('gpc-active', 'active')

@section('content')
<div class="card">
    <div class="card-header">Planifications</div>
    <div class="card-body">
        <div class="table-responsive" style="max-height: 200px;">
            <table class="table table-stripped table-hover table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Année</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Demandeur</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Service</th>
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
                            <td>{{ $item->Nom }} {{ $item->Prénom }}</td>
                            <td>{{ $item->Libelle }}</td>
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
                                @if (($item->VRH == 0 && $item->VCS == 0) || ($item->VCS == 1 && $item->VRH == 0))
                                    <form action="{{ route('ValPlan') }}" method="POST" style="display: inline;">@csrf
                                        @method("post") <button type="submit" class="btn" name="id"
                                            value="{{ $item->id }}">
                                            <li class="fa fa-check text-success"></li>
                                        </button></form>

                                        <form action="{{ route('RefPlan') }}" method="POST" style="display: inline;">@csrf
                                            @method("post") <button type="submit" class="btn" name="id"
                                                value="{{ $item->id }}">
                                                <li class="fa fa-times text-danger"></li>
                                            </button></form>
                                @endif
                                    
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection