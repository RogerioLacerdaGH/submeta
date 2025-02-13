@extends('layouts.app')

@section('content')
    @php
        $grandesAreas = \App\GrandeArea::all();
    @endphp

    <div class="row justify-content-center" style="margin-top: 100px;">
        <!--Titulos -->
        <div class="col-md-10">
            @if (session('sucesso'))
                <div class="alert alert-success">
                    <strong>{{ session('sucesso') }}</strong>
                </div>
            @endif
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #1492E6;">{{$trabalho->titulo}}</h5></div>
                            <div class="col-md-12"><h6 style="color: #234B8B; margin-bottom:-0.4rem; font-weight: bold">{{$evento->nome}}</h6></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Areas-->
        <div class="col-md-10">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Área de Ensino</h5></div>
                            <div class="col-md-12"><h6 style="color: #234B8B; margin-bottom:-0.4rem">
                                    {{App\GrandeArea::where('id', $trabalho->grande_area_id)->first()->nome}} >
                                    {{App\Area::where('id', $trabalho->area_id)->first()->nome}}
                                    @if(App\SubArea::where('id', $trabalho->sub_area_id)->first() != null)> {{App\SubArea::where('id', $trabalho->sub_area_id)->first()->nome}}@endif

                                </h6></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Informações Proponente-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <br>
        <div class="col-md-10">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Informações do Proponente</h5></div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">
                        <div class="form-row mt-3">
                            <div class="col-md-12">
                                <p style="color: #4D4D4D; padding: 0px"><b>Nome:</b> {{ App\Proponente::find($trabalho->proponente_id)->user->name }}</p>
                            </div>
                            <div class="col-md-12">
                                <b style="color: #4D4D4D;">Lattes:</b>
                                @if(App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes != null)
                                    <a style="color: #4D4D4D;" href="{{ App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes }}"
                                       target="_blank"
                                    >{{ App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes }}</a>
                                @endif
                            </div>

                            @if($evento->tipo != "PIBEX")
                            <div class="col-md-12">
                                <br>
                                <b style="color: #4D4D4D;">Grupo de Pesquisa: </b>
                                <a style="color: #4D4D4D;" href="{{ $trabalho->linkGrupoPesquisa }}"
                                   target="_blank"
                                >{{ $trabalho->linkGrupoPesquisa }}</a>
                            </div>

                            <div class="col-md-12">
                                <br>
                                <b style="color: #4D4D4D;">Valor da Planilha de Pontuação: </b>
                                <a style="color: #4D4D4D;">{{$trabalho->pontuacaoPlanilha}}</a>
                            </div>
                            @endif
                            @if($trabalho->modalidade != null)
                                <div class="col-md-12">
                                    <br>
                                    <b style="color: #4D4D4D;">Modalidade: </b>
                                    <a style="color: #4D4D4D;">{{$trabalho->modalidade}}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Discentes-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-10">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-sm-9"><h5 style="color: #234B8B; font-weight: bold">Discentes</h5></div>
                            <div class="col-sm-3 text-sm-right" >
                                @if($substituicoesPendentes->count() > 0)
                                    <a href="" data-toggle="modal" data-target="#modalVizuSubstituicao" class="button">Substituições Pendentes</a>
                                    <img class="" src="{{asset('img/icons/warning.ico')}}" style="width:15px" alt="">
                                @else
                                    <a href="" data-toggle="modal" data-target="#modalVizuSubstituicao" class="button">Substituições/Desligamentos</a>
                                @endif
                            </div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        <div class="row justify-content-start" style="alignment: center">
                            @foreach($trabalho->participantes as $participante)
                                <div class="col-sm-1">
                                    <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                </div>
                                <div class="col-sm-5">
                                    <h5>{{$participante->user->name}}</h5>
                                    <h9>
                                        <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$participante->id}}" class="button">Informações</a>
                                    </h9>
                                    <br>
                                    <a href="" >
                                        Remover
                                    </a>
                                </div>

                                <!-- Modal visualizar informações participante -->
                                <div class="modal fade" id="modalVizuParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                @include('administrador.substituirParticipanteForm', ['visualizarOnly' => 1])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach($substituicoesProjeto as $subs)

                                <!-- Modal vizualizar info participante substituido -->
                                    <div class="modal fade" id="modalVizuParticipanteSubstituido{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                    <button type="button" class="close" aria-label="Close" style="padding-top: 8px; color:#1492E6" onclick="abrirHistorico({{$subs->participanteSubstituido()->withTrashed()->first()->id}}, 1)">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                    @include('administrador.vizualizarParticipante', ['visualizarSubstituido' => 1])
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal vizualizar info participante substituto -->
                                    <div class="modal fade" id="modalVizuParticipanteSubstituto{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                    <button type="button" class="close" aria-label="Close" style="padding-top: 8px; color:#1492E6" onclick="abrirHistorico({{$subs->participanteSubstituto()->withTrashed()->first()->id}}, 2)">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                    @include('administrador.vizualizarParticipante')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Modal reprovar substituição -->
                                <div class="modal fade" id="modalCancelarSubst" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header" style="overflow-x:auto">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">Cancelar Substituição</h5>

                                                <button type="button" class="close" id="closeCancel" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="POST" id="CancelarSubParticForm" action="{{route('trabalho.aprovarSubstituicao')}}">
                                                    @csrf
                                                    <input type="hidden" name="substituicaoID" id="negaId"value="">
                                                    <input type="hidden" name="aprovar" value="false">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="justificativaTextArea">Justificativa:</label>
                                                                <textarea class="form-control" id="justificativaTextArea" rows="3" name="textJustificativa" minlength="20" required></textarea>
                                                            </div>
                                                            <select class="custom-select" name="selectJustificativa" >
                                                                <option value="DESISTENCIA">DESISTÊNCIA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end mt-4">
                                                        <div class="col-md-auto">
                                                            <div><button type="submit" class="btn btn-success">Cancelar Substituição</button></div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal aprovar substituição -->
                                <div class="modal fade" id="modalResultadoSubst" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header" style="overflow-x:auto">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">Proceder Com Substituição</h5>

                                                <button id="closeAcept" type="button" class="close" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="POST" id="AprovarSubParticForm" action="{{route('trabalho.aprovarSubstituicao')}}">
                                                    @csrf
                                                    <input type="hidden" name="substituicaoID" id="aprovaId" value="">
                                                    <input type="hidden" name="aprovar" value="true">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="justificativaTextArea">Justificativa:</label>
                                                                <textarea class="form-control" id="justificativaTextArea" rows="3" name="textJustificativa" minlength="20" required>Substituição cumpre com todos os requisitos</textarea>
                                                            </div>
                                                            <select class="custom-select" name="selectJustificativa" >
                                                                <option value="DESISTENCIA">DESISTÊNCIA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end mt-4">
                                                        <div class="col-md-auto">
                                                            <div><button type="submit" class="btn btn-success">Aprovar Substituição</button></div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Anexos-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-10">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Anexos</h5></div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        {{-- Anexo do Projeto --}}
                        <div class="row justify-content-start">
                            {{-- Arquivo  --}}
                            <div class="col-sm-4">
                                <label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold">{{ __('Projeto: ') }}</label>
                                <a href="{{ route('baixar.anexo.projeto', ['id' => $trabalho->id])}}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>

                            </div>

                            @if($evento->tipo != "PIBEX")
                            <div class="col-sm-4">
                                <label for="anexoLatterCoordenador" class="col-form-label font-tam" style="font-weight: bold">{{ __('Lattes do Coordenador: ') }}</label>
                                <a href="{{ route('baixar.anexo.lattes', ['id' => $trabalho->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>

                            </div>
                            @endif

                            @if($evento->tipo != "PIBEX")
                            <div class="col-sm-4">
                                <label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Autorização Especial: ') }}</label>
                                @if($trabalho->anexoAutorizacaoComiteEtica != null)
                                    <a href="{{ route('baixar.anexo.comite', ['id' => $trabalho->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                @else
                                    -
                                @endif
                            </div>
                            @endif

                            @if($evento->tipo != "PIBEX")
                            <div class="col-sm-4">
                                <label for="anexoPlanilha" class="col-form-label font-tam" style="font-weight: bold">{{ __('Planilha de Pontuação: ') }}</label>
                                <a href="{{ route('baixar.anexo.planilha', ['id' => $trabalho->id]) }}"><img class="" src="{{asset('img/icons/xlsx.ico')}}" style="width:40px" alt=""></a>

                            </div>
                            @endif

                            @if($evento->tipo != "PIBEX")
                            <div class="col-sm-4">
                                <label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Grupo de Pesquisa: ') }}</label>
                                @if($trabalho->anexoGrupoPesquisa != null)
                                    <a href="{{ route('baixar.anexoGrupoPesquisa', ['id' => $trabalho->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                @else
                                    -
                                @endif
                            </div>
                            @endif

                            @if($evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM' || $evento->tipo == "PIBEX")
                                {{-- Decisão do CONSU --}}
                                <div class="col-sm-4">
                                    <label for="anexoCONSU" class="col-form-label font-tam" style="font-weight: bold">{{ __('Decisão do CONSEPE: ') }}</label>
                                    <a href="{{ route('baixar.anexo.consu', ['id' => $trabalho->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Relatórios-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-10">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-sm-9"><h5 style="color: #234B8B; font-weight: bold">Relatórios</h5></div>
                            <div class="col-sm-3 text-sm-right" >
                                <a href="{{route('planos.listar', ['id' => $trabalho->id])}}"  class="button">Listar Relatórios</a>
                            </div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        <div class="row justify-content-center">
                            {{-- Relatório Parcial  --}}
                            <div class="col-sm-3">
                                <label for="dt_inicioRelatorioParcial" class="col-form-label font-tam" style="font-weight: bold">{{ __('Início do Relatório Parcial: ') }}</label>
                            </div>
                            <div class="col-sm-3">
                                <input id="dt_inicioRelatorioParcial{{$evento->id}}" type="date" class="form-control" name="dt_inicioRelatorioParcial" value="{{$evento->dt_inicioRelatorioParcial}}" required autocomplete="dt_inicioRelatorioParcial" disabled autofocus>
                            </div>
                            <div class="col-sm-3">
                                <label for="dt_fimRelatorioParcial" class="col-form-label font-tam" style="font-weight: bold">{{ __('Fim do Relatório Parcial: ') }}</label>
                            </div>
                            <div class="col-sm-3">
                                <input id="dt_fimRelatorioParcial{{$evento->id}}" type="date" class="form-control" name="dt_fimRelatorioParcial" value="{{$evento->dt_fimRelatorioParcial}}" required autocomplete="dt_fimRelatorioParcial" disabled autofocus>
                            </div>
                            {{-- Relatório Final --}}
                            <div class="col-sm-3">
                                <label for="dt_inicioRelatorioFinal" class="col-form-label font-tam" style="font-weight: bold">{{ __('Início do Relatório Final:') }}</label>
                            </div>
                            <div class="col-sm-3">
                                <input id="dt_inicioRelatorioFinal{{$evento->id}}" type="date" class="form-control" name="dt_inicioRelatorioFinal" value="{{$evento->dt_inicioRelatorioFinal}}" required autocomplete="dt_inicioRelatorioFinal" disabled autofocus>
                            </div>
                            <div class="col-sm-3">
                                <label for="dt_fimRelatorioFinal" class="col-form-label font-tam" style="font-weight: bold">{{ __('Fim do Relatório Final:') }}</label>
                            </div>
                            <div class="col-sm-3">
                                <input id="dt_fimRelatorioFinal{{$evento->id}}" type="date" class="form-control" name="dt_fimRelatorioFinal" value="{{$evento->dt_fimRelatorioFinal}}" required autocomplete="dt_fimRelatorioFinal" disabled autofocus>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Avaliadores-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-10">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-11"><h5 style="color: #234B8B; font-weight: bold">Avaliadores</h5></div>
                            <div class="col-md-1 text-sm-right">
                                <a type="button" value="{{ $trabalho->id }}" id="atribuir1" data-toggle="modal" data-target="#avaliadorModalCenter">
                                    <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="avaliadorModalCenter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow-y: hidden">
                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                    <div class="modal-content modal-submeta modal-xl">
                                        <div class="modal-header modal-header-submeta">
                                            <div class="col-md-8" style="padding-left: 0px">
                                                <h5 class="modal-title titulo-table" id="avaliadorModalLongTitle">Seleciones o(s) avaliador(es)</h5>
                                            </div>
                                            <div class="col-md-4" style="text-align: right">
                                                <button type="button" id="enviarConviteButton" class="btn btn-info" data-toggle="modal" onclick="abrirModalConvite()">
                                                    Enviar Convites
                                                </button>
                                                <button type="button" class="close" aria-label="Close" data-dismiss="modal" style="color: rgb(182, 182, 182);padding-right: 0px;">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            @if (session('error'))
                                                <div class="col-md-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <p>{{ session('error') }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <form action="{{ route('admin.atribuicao.projeto') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">
                                                <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                                                <div class="form-group">
                                                    <div class="row" style="margin-left: 2px;margin-bottom: 1px">

                                                        <div class="col-md-6">
                                                    <label for="exampleFormControlSelect2"  style="font-size: 16px;">Selecione o(s) avaliador(es) para esse projeto</label>
                                                        </div>


                                                        <div class="col-md-3" style="text-align: center;overflow-y:  auto;overflow-x:  auto">

                                                            <select class="form-control" id="grandeArea" name="grande_area_id" onchange="areasFiltro()" >
                                                                <option value="" disabled selected hidden>-- Grande Área --</option>
                                                                @foreach($grandesAreas as $grandeArea)
                                                                    <option title="{{$grandeArea->nome}}" value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3" style="text-align: center;overflow-y:  auto;overflow-x:  auto">
                                                            <input type="hidden" id="oldArea" value="{{ old('area') }}" >
                                                            <select class="form-control @error('area') is-invalid @enderror" id="area" name="area_id" onchange="(consultaExterno(),consultaInterno())" >
                                                                <option value="" disabled selected hidden>-- Área --</option>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label style="font-weight: bold;font-size: 18px">Externos</label>
                                                    </div>

                                                    <input type="hidden" id="trab" value="{{$trabalho->id}}">
                                                    <input type="hidden" id="oldAvalExterno" value="{{ old('exampleFormControlSelect3') }}" >
                                                    <select  name="avaliadores_externos_id[]" multiple class="form-control" id="exampleFormControlSelect3" style="height: 200px;font-size:15px">
                                                        @foreach ($trabalho->aval as $avaliador)
                                                            @if($avaliador->tipo == "Externo")
                                                                <option value="{{ $avaliador->id }}" > {{ $avaliador->user->name }} > {{$avaliador->user->instituicao ?? 'Instituição Indefinida'}} > {{$avaliador->area->nome ?? 'Indefinida'}} > {{$avaliador->user->email}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="col-md-6">
                                                        <label style="font-weight: bold;font-size: 18px">Internos</label>
                                                    </div>
                                                    <input type="hidden" id="oldAvalInterno" value="{{ old('exampleFormControlSelect2') }}" >
                                                    <select  name="avaliadores_internos_id[]" multiple class="form-control" id="exampleFormControlSelect2" style="height: 200px;font-size: 15px">
                                                        @foreach ($trabalho->aval as $avaliador)
                                                            @if($avaliador->tipo == "Interno")
                                                                <option value="{{ $avaliador->id }}" > {{ $avaliador->user->name }} > {{$avaliador->user->instituicao ?? 'Instituição Indefinida'}} > {{$avaliador->area->nome ?? 'Indefinida'}} > {{$avaliador->user->email}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <small id="emailHelp" class="form-text text-muted">Segure SHIFT do teclado para selecionar mais de um.</small>
                                                </div>

                                                <div>
                                                    <button type="submit" class="btn btn-info" style="width: 100%">Atribuir</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr style="border-top: 1px solid#1492E6">
                        <!--Comissão Externa-->
                        <div class="row justify-content-start" style="alignment: center">
                            <div class="col-md-11"><h6 style="color: #234B8B; font-weight: bold">Avaliadores - Externos</h6></div>
                        </div>
                        <div class="row justify-content-start" style="alignment: center">
                            @foreach($trabalho->avaliadors as $avaliador)
                                @if($avaliador->tipo == 'Externo' || $avaliador->tipo == null)
                                    <div class="col-sm-1">
                                        <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                    </div>
                                    <div class="col-sm-5">
                                        <h5>{{$avaliador->user->name}}</h5>
                                        @if($avaliador->tipo == 'Externo' || $avaliador->tipo == null)
                                            <h9>@if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->parecer == null) Pendente @else <a href="{{ route('admin.visualizarParecer', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}">Avaliado</a> @endif</h9>
                                        @else
                                            @php
                                                $parecerInterno = App\ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                                            @endphp
                                            <h9>@if($parecerInterno == null) Pendente @else <a href="{{ route('admin.visualizarParecerInterno', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}">Avaliado</a> @endif</h9>
                                        @endif
                                       {{-- <br>
                                        <a href="{{ route('admin.removerProjAval', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}" >
                                            Remover
                                        </a>--}}
                                        <br>
                                        <a href="{{ route('admin.reenviar.atribuicao.projeto', ['evento_id' => $evento->id, 'avaliador_id'=>$avaliador->id, 'trabalho_id' => $trabalho->id]) }}">
                                            Reenviar convite
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <br>
                        <!--Comissão Interna-->
                        <div class="row justify-content-start" style="alignment: center">
                            <div class="col-md-11"><h6 style="color: #234B8B; font-weight: bold">Avaliadores - Internos</h6></div>
                        </div>
                        <div class="row justify-content-start" style="alignment: center">
                            @foreach($trabalho->avaliadors as $avaliador)
                                @if($avaliador->tipo == 'Interno')
                                    <div class="col-sm-1">
                                        <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                    </div>
                                    <div class="col-sm-5">
                                        <h5>{{$avaliador->user->name}}</h5>
                                        @php
                                            $parecerInterno = App\ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                                        @endphp
                                        <h9>@if($parecerInterno == null) Pendente @else <a href="{{ route('admin.visualizarParecerInterno', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}">Avaliado</a> @endif</h9>
                                        <br>
                                       {{-- <a href="{{ route('admin.removerProjAval', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}" >
                                            Remover
                                        </a>--}}
                                        <a href="{{ route('admin.reenviar.atribuicao.projeto', ['evento_id' => $evento->id, 'avaliador_id'=>$avaliador->id, 'trabalho_id' => $trabalho->id]) }}">
                                            Reenviar convite
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Aprovar ou Negar Proposta-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-10">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-11"><h5 style="color: #234B8B; font-weight: bold">Recomendação</h5></div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">
                        <form  action="{{ route('trabalho.aprovarProposta', ['id' => $trabalho->id]) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <a class="col-md-12 text-left" style="padding-left: 0px;color: #234B8B; font-weight: bold;">Comentário</a>
                                    <textarea class="col-md-12" id="comentario" name="comentario" style="border-radius:5px 5px 0 0;height: 71px;" required
                                    >@if($trabalho->comentario != null){{$trabalho->comentario}}@endif</textarea>
                                </div>
                                <div class="col-md-3" style="margin-top: 15px">
                                    <input class="col-md-1" type="radio" id="aprovado" name="statusProp" value="aprovado" required
                                           @if($trabalho->status=="aprovado") checked @endif>
                                    <a style="color: #234B8B; font-weight: bold;font-size: 18px;">Recomendado</a>
                                    <br>
                                    <input class="col-md-1" type="radio" id="parcialAprovado" name="statusProp" value="corrigido" required
                                           @if($trabalho->status=="corrigido") checked @endif>
                                    <a style="color: #234B8B; font-weight: bold;font-size: 18px;">Parcialmente Recomendado</a>
                                    <br>
                                    <input class="col-md-1" type="radio" id="reprovado" name="statusProp" value="reprovado" required
                                           @if($trabalho->status=="reprovado") checked @endif>
                                    <a style="color: #234B8B; font-weight: bold;font-size: 18px;">Não Recomendado</a>
                                </div>
                            </div>

                            <button id="enviar" name="enviar" type="submit" class="btn btn-primary" style="padding: 5px 10px;font-size: 18px;">
                                Salvar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal visualizar substituição-->
    <div class="modal fade" id="modalVizuSubstituicao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header" style="overflow-x:auto">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #234B8B; font-weight: bold">Substituição de Discentes</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="TabControl">
                        <div id="header" style="border: none">
                            <ul class="abas" style="list-style-type:none;">
                                <li>
                                    <div class="aba1 aba">
                                        <span>Substituções </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="aba2 aba">
                                        <span> Histórico</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="aba3 aba">
                                        <span> Desligamentos</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div id="content">
                            <div class="justify-content-center conteudo" id="tela1" style="margin-top: 0px;border: none;overflow-x: auto;">
                                <div class="col-md-12" id="tela1" style="padding: 0px">
                                    <div class="card" id="tela1" style="border-radius: 5px">
                                        <div class="card-body" id="tela1" style="padding-top: 0.2rem;padding-right: 0px;padding-left: 5px;padding-bottom: 5px;">
                                            <div class="" id="tela1">
                                                <div class="justify-content-start" id="tela1" style="alignment: center">
                                                    @foreach($substituicoesPendentes as $subs)
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <h5 style="color: #234B8B; font-weight: bold" class="col-md-12">Substituição</h5>
                                                                <div class="row">
                                                                    <div class="col-md-1">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}" style="width:50px" alt="">
                                                                    </div>
                                                                    <div class="col-md-4" style="padding-left: 20px;padding-right: 5px;">
                                                                        <a onclick="vizuParticipante({{$subs->participanteSubstituido()->withTrashed()->first()->id}})" class="button">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</a>
                                                                    </div>
                                                                    <div class="col-md-1 text-left" style="padding-left: 0px;">
                                                                        <img src="{{asset('img/seta.png')}}" style="width:40px;margin-left: 5px;margin-right: 10px;" alt="">
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}" style="width:50px" alt="">
                                                                    </div>
                                                                    <div class="col-md-4" style="padding-left: 20px;padding-right: 5px;">
                                                                        <a onclick="fecharModalSubstituto({{$subs->participanteSubstituto()->withTrashed()->first()->id}})" class="button">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <h5 style="color: #234B8B; font-weight: bold" class="col-md-12 text-center">  Ações</h5>
                                                                <div class="col-md-12 text-center" id="tela1" style="border: solid#1111; padding: 10px; ">
                                                                    <form >
                                                                        <input type="radio" id="aceitar" name="opcao" value="aceitar"> Aprovar
                                                                        <input type="radio" id="negar" name="opcao" value="negar"> Negar
                                                                        <br>
                                                                        <button id="submeter" name="submeter" type="button" class="btn btn-primary" style="padding: 5px 10px;" value="{{$subs->id}}">
                                                                            Submeter
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="justify-content-center conteudo" id="tela2" style="margin-top: 0px;border: none;overflow-x: auto;">
                                {{--<div class="col-md-12" id="tela2" style="padding: 0px">
                                    <div class="card" id="tela2" style="border-radius: 5px">
                                        <div class="card-body" id="tela2" style="padding-top: 0.2rem;padding-right: 0px;padding-left: 5px;padding-bottom: 5px;">
                                            <div class="" id="tela2">
                                                <div class="justify-content-start" id="tela2" style="alignment: center">
                                                    @foreach($substituicoesProjeto as $subs)
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <h5 style="color: #234B8B; font-weight: bold" class="col-md-12">Substituição</h5>
                                                                <div class="row">
                                                                    <div class="col-md-1">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}" style="width:50px" alt="">
                                                                    </div>
                                                                    <div class="col-md-4" style="padding-left: 20px;padding-right: 5px;">
                                                                        <a onclick="vizuPartici({{$subs->participanteSubstituido()->withTrashed()->first()->id}})" class="button tiro">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</a>
                                                                    </div>
                                                                    <div class="col-md-1 text-left" style="padding-left: 0px;">
                                                                        <img src="{{asset('img/seta.png')}}" style="width:40px;margin-left: 5px;margin-right: 10px;" alt="">
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}" style="width:50px" alt="">
                                                                    </div>
                                                                    <div class="col-md-4" style="padding-left: 20px;padding-right: 5px;">
                                                                        <a onclick="vizuPartici({{$subs->participanteSubstituto()->withTrashed()->first()->id}})" class="button">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                @if($subs->tipo == 'ManterPlano')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Tipo: Manter Plano</>
                                                                @elseif($subs->tipo == 'TrocarPlano')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Tipo: Alterar Plano</h5>
                                                                @elseif($subs->tipo == 'Completa')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Tipo: Completa</h5>
                                                                @endif
                                                                @if($subs->status == 'Finalizada')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Status: Concluída</h5>
                                                                @elseif($subs->status == 'Negada')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Status: Negada</h5>
                                                                @elseif($subs->status == 'Em Aguardo')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Status: Pendente</h5>
                                                                @endif
                                                                @if($subs->status == 'Em Aguardo')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Pendente</h5>
                                                                @else
                                                                    <a onclick="vizuJustificativa('{{$subs->justificativa}}')" class="button"><h5 style="color: #234B8B; " class="col-md-12 text-center">Visualizar</h5></a>
                                                                @endif

                                                            </div>
                                                        </div>

                                                        <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                                <div style="margin-top: 5px">
                                    <div class="card-header">
                                        <div class="row">
                                                <div class="col-3">
                                                    <h6 class="card-title" style= "color:#234B8B">
                                                        Participante Substituído
                                                    </h6>
                                                </div>
                                                <div class="col-3">
                                                    <h6 class="card-title" style= "color:#234B8B">
                                                        Participante Substituto
                                                    </h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="card-title" style= "color:#234B8B">
                                                        Tipo
                                                    </h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="card-title" style= "color:#234B8B">
                                                        Status
                                                    </h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="card-title" style= "color:#234B8B">
                                                        Justificativa
                                                    </h6>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        @foreach($substituicoesProjeto as $subs)
                                            <div class="row" style="margin-bottom: 20px;">
                                                <div class="col-3">
                                                    <a href="" data-toggle="modal" class="button" onclick="fecharModalSubstituido({{$subs->participanteSubstituido()->withTrashed()->first()->id}})"><h6 style="font-size:18px;  color: black" >{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</h6></a>
                                                    <h6 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->data_entrada))}} - @if($subs->participanteSubstituido()->withTrashed()->first()->data_saida == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->data_saida))}} @endif</h6>
                                                </div>
                                                <div class="col-3">
                                                    <a href="" data-toggle="modal" class="button" onclick="fecharModalSubstituto({{$subs->participanteSubstituto()->withTrashed()->first()->id}})"><h6 style="font-size:18px;  color: black">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</h6></a>
                                                    <h6 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->data_entrada))}} - @if($subs->participanteSubstituto()->withTrashed()->first()->data_saida == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->data_saida))}} @endif</h6>
                                                </div>
                                                <div class="col-2">
                                                    @if($subs->tipo == 'ManterPlano')
                                                        <h6>Manter Plano</h6>
                                                    @elseif($subs->tipo == 'TrocarPlano')
                                                        <h6>Alterar Plano</h6>
                                                    @elseif($subs->tipo == 'Completa')
                                                        <h6>Completa</h6>
                                                    @endif
                                                </div>
                                                <div class="col-2">
                                                    @if($subs->status == 'Finalizada')
                                                        <h6>Concluída</h6>
                                                    @elseif($subs->status == 'Negada')
                                                        <h6>Negada</h6>
                                                    @elseif($subs->status == 'Em Aguardo')
                                                        <h6>Pendente</h6>
                                                    @endif
                                                </div>
                                                <div class="col-2">
                                                    @if($subs->status == 'Em Aguardo')
                                                        <h6>Pendente</h6>
                                                    @else
                                                        <a href="" data-toggle="modal" class="button" onclick="vizuJustificativa('{{$subs->justificativa}}')"><h5 style="font-size:18px">Visualizar</h5></a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-center conteudo" id="tela3" style="margin-top: 0px;border: none;overflow-x: auto;">
                                <div class="col-md-12" style="padding: 0px">
                                    <div class="card" style="border-radius: 5px">
                                        <div class="card-body"  style="padding-top: 0.2rem;padding-right: 0px;padding-left: 5px;padding-bottom: 5px;">
                                            <div class="">
                                                <div class="justify-content-start" style="alignment: center">
                                                    @foreach($trabalho->desligamentos as $desligamento)
                                                        <div class="row justify-content-between">
                                                            <div class="col-md-9">
                                                                <h5 style="color: #234B8B; font-weight: bold" class="col-md-12">Desligamento</h5>
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="col-md-2">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}" style="width:50px" alt="" class="img-flex">
                                                                    </div>
                                                                    <div class="col-md-10" >
                                                                        <a onclick="vizuParticipante({{$desligamento->participante()->withTrashed()->first()->id}})" class="button">{{$desligamento->participante()->withTrashed()->first()->user->name}}</a>
                                                                        <br><label for="justificativa">Justificativa: </label>
                                                                        {{$desligamento->justificativa}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                @if($desligamento->status == \App\Desligamento::STATUS_ENUM['solicitado'])
                                                                    <h5 style="color: #234B8B; font-weight: bold" class="col-md-12 text-center"> Ações</h5>
                                                                    <div class="col-md-12 text-center" style="border: solid#1111; padding: 10px; ">
                                                                        <form id="resposta-desligamento{{$desligamento->id}}" method="POST" action="{{route('coordenador.resposta.desligamento', ['desligamento_id' => $desligamento->id]) }}">
                                                                            @csrf
                                                                            <input type="hidden" id="desligamento" name="desligamento" value="{{$desligamento->id}}">
                                                                            <input type="radio" id="aceitar{{$desligamento->id}}" name="opcao" value="{{\App\Desligamento::STATUS_ENUM['aceito']}}"> Aprovar
                                                                            <input type="radio" id="negar{{$desligamento->id}}" name="opcao" value="{{\App\Desligamento::STATUS_ENUM['recusado']}}"> Negar
                                                                            <br>
                                                                            <button type="submit" class="btn btn-primary" form="resposta-desligamento{{$desligamento->id}}">Submeter</button>
                                                                        </form>
                                                                    </div>
                                                                @else
                                                                    <h5 style="color: #234B8B; font-weight: bold" class="col-md-12 text-center"> Status</h5>
                                                                    <div class="col-md-12 text-center" style="border: solid#1111; padding: 10px; ">
                                                                        {{$desligamento->getStatus()}}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                {{--<div class="modal-body">
                    @include('administrador.substituirParticipanteForm', ['visualizarOnly' => 1])
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Modal vizualizar justificativa -->
    <div class="modal fade" id="modalVizuJustificativa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="overflow-x:auto">
                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Justificativa</h5>
                    <button type="button" class="close" onclick="closeJustificativa()" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 style="font-size:18px" id="conteudoJustificativa"></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal enviar convite e atribuir -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content modal-submeta">
            <div class="modal-header modal-header-submeta">
              <h5 class="modal-title titulo-table" id="exampleModalLongTitle" style="font-size: 20px;">Enviar Convite</h5>
              <button type="button" class="close"  onclick="fecharModalConvite()" aria-label="Close" style="color: rgb(182, 182, 182)">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" style="margin-left: 20px; margin-right: 20px;">
      
              <form action="{{ route('admin.convite.atribuicao.projeto') }}" method="POST" class="labels-blue">
                @csrf
                <input type="hidden" name="evento_id" value="{{ $evento->id }}" >
                <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" >
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome Completo <span style="color: red;">*</span></label>
                  <input type="text" class="form-control" name="nomeAvaliador" id="exampleInputNome1" required>            
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email <span style="color: red;">*</span></label>
                  <input type="email" class="form-control" name="emailAvaliador" id="exampleInputEmail1" required>            
                </div>
      
                <div class="form-group">
                <label for="grandeArea" class="col-form-label">{{ __('Grande Área') }} <span style="color: red; font-weight:bold">*</span></label>
                    <select class="form-control" id="grandeAreaConvite" name="grande_area_id" onchange="areas()" required>
                      <option value="" disabled selected hidden>-- Grande Área --</option>
                      @foreach($grandeAreas as $grandeArea)
                      <option value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                      @endforeach
                    </select>
      
                    <label for="area" class="col-form-label">{{ __('Área') }} <span style="color: red; font-weight:bold">*</span></label>
                    <select class="form-control @error('area') is-invalid @enderror" id="areaConvite" name="area_id" required>
                      <option value="" disabled selected hidden>-- Área --</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Tipo</label>
                  <select class="form-control" name="tipo" id="exampleFormControlSelect1" disabled>
                    <option value="avaliador" >Avaliador</option>
                  </select>
                </div>
      
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Instituição <span style="color: red; font-weight:bold">*</span></label>
                  <select class="form-control" name="instituicao" id="membro" required onchange="mostrarDiv(this)">
                    <option value="" disabled>-- Selecione a instituição --</option>
                    <option value="ufape" >Universidade Federal do Agreste de Pernambuco</option>
                    <option value="outra" >Outra</option>
                  </select>
                </div>
      
                <div class="form-group" id="div-outra" style="@if(old('instituicao') != null && old('instituicao') == "outra") display: block; @else display: none; @endif">
                  <label for="outra">{{ __('Digite o nome da instituição') }}<span style="color: red; font-weight: bold;"> *</span></label>
                  <input id="outra" class="form-control @error('outra') is-invalid @enderror" type="text" name="outra" value="{{old('outra')}}" autocomplete="outra" placeholder="Universidade Federal ...">
                  @error('outra')
                      <div id="validationServer03Feedback" class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
      
                <div class="form-group" style="margin-top: 40px; margin-bottom: 40px;">
                  <button type="submit" class="btn btn-info" style="width: 100%">Enviar</button>
                </div> 
                <div class="form-group texto-info">
                  O convite será enviador por e-mail e o preenchimento dos dados será de inteira responsabilidade do usuário convidado.
                </div>
              </form>
      
            </div>
          </div>
        </div>
    </div>

    <style>
        body{font-family:Calibri, Tahoma, Arial}
        .TabControl{ width:100%; overflow:hidden; height:400px}
        .TabControl #header{ width:100%; overflow:hidden}
        .TabControl #content{ width:100%; overflow:hidden; height:100%; }
        .TabControl .abas{display:inline;}
        .TabControl .abas li{float:left}
        .aba{width:100px; height:30px; border-radius:5px 5px 0 0;
            text-align:center; padding-top:5px;}
        .ativa{width:100px; height:30px; border-radius:5px 5px 0 0;
            text-align:center; padding-top:5px; background:#27408B;}
        .ativa span, .selected span{color:#fff}
        .TabControl .conteudo{width:100%; display:none; height:100%;}
        .selected{width:100px; height:30px; border-radius:5px 5px 0 0;
            text-align:center; padding-top:5px; background:#27408B}
    </style>
@endsection

@section('javascript')
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#content div:nth-child(1)").show();
            $(".abas li:first div").addClass("selected");
            $(".aba2").click(function(){
                $(".aba1").removeClass("selected");
                $(".aba3").removeClass("selected");
                $(this).addClass("selected");
                $("#tela1").hide();
                $("#tela3").hide();
                $("#tela2").show();
            });
            $(".aba1").click(function(){
                $(".aba2").removeClass("selected");
                $(".aba3").removeClass("selected");
                $(this).addClass("selected");
                $("#tela2").hide();
                $("#tela3").hide();
                $("#tela1").show();
            });
            $(".aba3").click(function(){
                $(".aba2").removeClass("selected");
                $(".aba1").removeClass("selected");
                $(this).addClass("selected");
                $("#tela2").hide();
                $("#tela1").hide();
                $("#tela3").show();
            });

            let textTemp = document.getElementById("comentario").innerHTML;

            document.getElementById("aprovado").onclick = function () {
                var s = document.getElementById("comentario");
                s.innerHTML = 'Proposta cumpriu todos os requisitos estabelecidos no edital';
            };
            document.getElementById("reprovado").onclick = function () {
                var s = document.getElementById("comentario");
                s.innerHTML = textTemp;
            };
            document.getElementById("parcialAprovado").onclick = function () {
                var s = document.getElementById("comentario");
                s.innerHTML = textTemp;
            };


        });
    </script>
    <script>

        function  vizuParticipante(id){
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {  $("#modalVizuParticipante"+id).modal(); }, 500);
        }
        function  vizuPartici(id){
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {  $("#modalVizuParticipanteSubstituto"+id).modal(); }, 500);
        }

        function vizuJustificativa(texto){
            $("#modalVizuSubstituicao").modal('hide');
            document.getElementById("conteudoJustificativa").innerHTML = texto;
            setTimeout(() => {  $("#modalVizuJustificativa").modal(); }, 500);
        }

        function  closeJustificativa(){
            $("#modalVizuJustificativa").modal('hide');
            setTimeout(() => {  $("#modalVizuSubstituicao").modal(); }, 500);
        }

    </script>

    <style>
        h6, a, b, p, .font-tam{
            font-size: 16.4px;
        }
        h5{
            font-size: 20px;
        }
    </style>

    <script type="text/javascript">
        var e = document.getElementById("submeter");
        e.onclick = function(){myFunction(e.value)};
        document.getElementById("closeAcept").onclick = function(){
            $("#modalResultadoSubst").modal('hide');
        };
        document.getElementById("closeCancel").onclick = function(){
            $("#modalCancelarSubst").modal('hide');
        };

        document.getElementById("teste").onclick = function(){
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {  $(document.getElementById("teste").getAttribute("name")).modal(); }, 500);
        };

        document.getElementById("teste2").onclick = function(){
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {  $(document.getElementById("teste2").getAttribute("name")).modal(); }, 500);
        };

        document.getElementById("teste3").onclick = function(){
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {  $(document.getElementById("teste2").getAttribute("name")).modal(); }, 500);
        };

        document.getElementById("teste4").onclick = function(){
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {  $(document.getElementById("teste2").getAttribute("name")).modal(); }, 500);
        };

        function myFunction(id) {
            if(document.getElementById("aceitar").checked){
                document.getElementById("aprovaId").value = id;
                $("#modalVizuSubstituicao").modal('hide');
                $("#modalResultadoSubst").modal();
            }else if (document.getElementById("negar").checked){
                document.getElementById("negaId").value = id;
                $("#modalVizuSubstituicao").modal('hide');
                $("#modalCancelarSubst").modal();
            }
        }

        function areasFiltro() {
            var grandeArea = $('#grandeArea').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('area.consulta') }}',
                data: 'id='+grandeArea ,
                headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: (dados) => {

                    if (dados.length > 0) {
                        if($('#oldArea').val() == null || $('#oldArea').val() == ""){
                            var option = '<option selected disabled>-- Área --</option>';
                        }
                        $.each(dados, function(i, obj) {
                            if($('#oldArea').val() != null && $('#oldArea').val() == obj.id){
                                option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
                            }else{
                                option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
                            }
                        })
                    } else {
                        var option = "<option selected disabled>-- Área --</option>";
                    }
                    $('#area').html(option).show();
                    subareas();
                },
                error: (data) => {
                    console.log(data);
                }

            })
        }
    </script>
    <script>
        function consultaExterno() {
            var area = $('#area').val();
            var job = $('#trab').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('aval.consultaExterno') }}',
                data: 'id='+area+"&trabalho_id="+job ,
                headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: (dados) => {

                    if (dados.length > 0) {
                        $.each(dados, function(i, obj) {

                                if(obj.instituicao==null){
                                    option += '<option value="' + obj.id + '">' + obj.name+' > '+'Instituição indefinida'+' > '+obj.nome+' > '+ obj.email+'</option>';
                                } else{
                                    option += '<option value="' + obj.id + '">' + obj.name+' > '+ obj.instituicao +' > '+obj.nome+' > '+ obj.email+'</option>';

                            }
                        })
                    } else {
                        var option = "<option selected disabled>Sem Resultado</option>";
                    }
                    $('#exampleFormControlSelect3').html(option).show();
                },
                error: (data) => {
                    console.log(data);
                }

            })
        }

        function consultaInterno() {
            var area = $('#area').val();
            var job = $('#trab').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('aval.consultaInterno') }}',
                data: 'id='+area+"&trabalho_id="+job ,
                headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: (dados) => {

                    if (dados.length > 0) {
                        $.each(dados, function(i, obj) {

                                if(obj.instituicao==null){
                                    option += '<option value="' + obj.id + '">' + obj.name+' > '+'Instituição indefinida'+' > '+obj.nome+' > '+ obj.email+'</option>';
                                } else{
                                    option += '<option value="' + obj.id + '">' + obj.name+' > '+ obj.instituicao +' > '+obj.nome+' > '+ obj.email+'</option>';
                                }

                        })
                    } else {
                        var option = "<option selected disabled>Sem Resultado</option>";
                    }
                    $('#exampleFormControlSelect2').html(option).show();
                },
                error: (data) => {
                    console.log(data);
                }

            })
        }
    </script>
    
    <script>
        if({!! json_encode(session('error'), JSON_HEX_TAG) !!})
        {
            $(document).ready(function(){
                $('#avaliadorModalCenter').modal('show');
            });
        }
    </script>

    <script>
        function fecharModalSubstituido(id){
            $('#modalVizuSubstituicao').modal('toggle');
            setTimeout(() => {  $("#modalVizuParticipanteSubstituido"+id).modal(); }, 500);
        }
        function fecharModalSubstituto(id){
            $('#modalVizuSubstituicao').modal('toggle');
            setTimeout(() => {  $("#modalVizuParticipanteSubstituto"+id).modal(); }, 500);
        }

        function abrirHistorico(id, modal){
            if(modal == 1){
                $('#modalVizuParticipanteSubstituido'+id).modal('hide');
            }else if(modal == 2){
                $('#modalVizuParticipanteSubstituto'+id).modal('hide');
            }else if(modal == 0){
                $('#modalVizuParticipante'+id).modal('hide');
            }
            setTimeout(() => {  $("#modalVizuSubstituicao").modal(); }, 500);
        }
    </script>

    <script>
        function abrirModalConvite(){
            $("#avaliadorModalCenter").modal('toggle');
            setTimeout(() => {  $("#exampleModalCenter").modal(); }, 500);
            $('#exampleModalCenter').focus();
        }

        function fecharModalConvite(){
            $('#exampleModalCenter').modal('toggle');
            setTimeout(() => {  $("#avaliadorModalCenter").modal(); }, 500);
            $('#avaliadorModalCenter').focus();
        }

        function areas() {
            var grandeArea = $('#grandeAreaConvite').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('area.consulta') }}',
                data: 'id='+grandeArea ,
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (dados) => {

                if (dados.length > 0) {
                if($('#oldArea').val() == null || $('#oldArea').val() == ""){
                    var option = '<option selected disabled>-- Área --</option>';
                }
                $.each(dados, function(i, obj) {
                    if($('#oldArea').val() != null && $('#oldArea').val() == obj.id){
                    option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
                    }else{
                    option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
                    }
                })
                } else {
                var option = "<option selected disabled>-- Área --</option>";
                }
                $('#areaConvite').html(option).show();
            },
                error: (data) => {
                    console.log(data);
                }

            })
        }
        function mostrarDiv(select) {
            if(select.value == "outra") {
                document.getElementById('div-outra').style.display = "block";
                $("#outra").prop('required',true);
            }else if(select.value == "ufape"){
            document.getElementById('div-outra').style.display = "none";
            $("#outra").prop('required',false);
            }
        }
    </script>
@endsection
