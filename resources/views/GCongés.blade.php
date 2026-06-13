@extends('Master.master')

@section('gdc-active', 'active')

@section('content')
    <div class="card">
        <div class="card-header">Congés</div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 200px;">
                <table class="table table-stripped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style="vertical-align : middle;text-align:center;">Demandeur</th>
                            <th style="vertical-align : middle;text-align:center;">Service</th>
                            <th style="vertical-align : middle;text-align:center;">Date Début</th>
                            <th style="vertical-align : middle;text-align:center;">Nombre des jours</th>
                            <th style="vertical-align : middle;text-align:center;">Type</th>
                            <th style="vertical-align : middle;text-align:center;">Etat</th>
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
                                        <form action="{{ route('ValCongé') }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method("post") <button type="submit" class="btn" name="id"
                                                value="{{ $item->id }}">
                                                <li class="fa fa-check text-success"></li>
                                            </button></form>
                                        <form action="{{ route('RefCongé') }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method("post") <button type="submit" class="btn" name="id"
                                                value="{{ $item->id }}">
                                                <li class="fa fa-times text-danger"></li>
                                            </button></form>
                                    @endif
                                    @if ($Service != null)
                                        @if ($Service->id == 2)
                                            @if ($item->VRH == 1)
                                                <a href="{{ route('gen', ['id' => $item->id]) }}" class="btn">
                                                    <li class="fa fa-print"></li>
                                                </a>
                                            @endif
                                        @endif
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
