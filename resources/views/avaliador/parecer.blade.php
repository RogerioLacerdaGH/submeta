@extends('layouts.app')

@section('content')


<div class="row justify-content-center">
	<!--Proponente Dados-->
	<div class="col-md-10" style="margin-top:4rem;padding: 0px">
		@component('projeto.formularioVisualizar.proponente2', ['projeto' => $trabalho])
		@endcomponent
	</div>

	<!--Anexos do Projeto-->
	<div class="col-md-10"  style="margin-top:20px">
		<div class="card" style="border-radius: 5px">
			<div class="card-body" style="padding-top: 0.2rem;">
				<div class="container">
					<div class="form-row mt-3">
						<div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Anexos</h5></div>
					</div>
					<hr style="border-top: 1px solid#1492E6">

					{{-- Anexo do Projeto --}}
					<div class="row justify-content-left">
						{{-- Arquivo  --}}
						<div class="col-sm-12">
							<label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold">{{ __('Projeto: ') }}</label>
							<a href="{{ route('baixar.anexo.projeto', ['id' => $trabalho->id])}}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>

						</div>
						<br>
						{{-- Autorização Especial --}}
						<div class="col-sm-12">
							<label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Autorização Especial: ') }}</label>
							@if($trabalho->anexoAutorizacaoComiteEtica != null)
								<a href="{{ route('baixar.anexo.comite', ['id' => $trabalho->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
							@else
								-
							@endif
						</div>
						<br>
						{{-- Anexo(s) do Plano(s) de Trabalho  --}}
						@foreach( $trabalho->participantes as $participante)
							@php
								if( App\Arquivo::where('participanteId', $participante->id)->first() != null){
                                  $planoTrabalhoTemp = App\Arquivo::where('participanteId', $participante->id)->first()->nome;
                                }else{
                                  $planoTrabalhoTemp = null;
                                }
							@endphp
							<div class="col-sm-12">
								<label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold"
								title="{{$participante->planoTrabalho->titulo}}">{{ __('Projeto: ') }}{{$participante->planoTrabalho->titulo}}</label>

								@if($planoTrabalhoTemp != null)
									<a href="{{route('download', ['file' => $planoTrabalhoTemp])}}"><img src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
								@endif
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

	  <div class="col-md-10" style="margin-bottom: -3rem;margin-top:20px">
		<div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px; overflow:auto">
		  <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
			<div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:-1rem">
			  <div class="bottomVoltar" style="margin-top: -20px">
				<a href="javascript:history.back()" class="btn btn-secondary" style=""><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
			  </div>
			  <div class="form-group">
				  <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Meu parecer</h5>
				  <h5 class="card-title mb-0" style="font-size:19px; font-family:Arial, Helvetica, sans-serif; color:#909090">Trabalho: {{ $trabalho->titulo }}</h5>
			  </div>
			  <div style="margin-top: -2rem">
				<div class="form-group">
				  <div style="margin-top:30px;">
				   {{-- Pesquisar--}}
				  </div>
				</div>
			  </div>
			</div>
		  </div>

		  <div class="card-body" >
			<form method="POST" action="{{route('avaliador.enviarParecer')}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" >
				<input type="hidden" name="evento_id" value="{{ $evento->id }}" >
				<div class="form-group">
					@component('componentes.input', ['label' => 'Parecer'])
						<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="textParecer" placeholder="Digite aqui o seu parecer" required>{{ $trabalho->pivot->parecer }}</textarea>
					@endcomponent
				</div>

				<div class="form-group">
					<div class="row justify-content-start">
						<div class="col-sm-3">
							@component('componentes.input', ['label' => 'Pontuação calculada'])
							<input type="number" min="0" step="1" name="pontuacao" style="width: 70px"
								   @if($trabalho->pivot!=null && $trabalho->pivot->pontuacao !=null )
								   value="{{$trabalho->pivot->pontuacao}}"
								   @else value="0"
								   @endif required>
							@endcomponent
						</div>
					</div>
				</div>


				<select class="custom-select" name="recomendacao" >
						<option  @if($trabalho->pivot->recomendacao =='RECOMENDADO' ) selected @endif value="RECOMENDADO">RECOMENDADO</option>	
						<option @if($trabalho->pivot->recomendacao =='NAO-RECOMENDADO' ) selected @endif value="NAO-RECOMENDADO">NAO-RECOMENDADO</option>												  
				</select>
				<div class="form-group  mt-3 md-3">
					<label >Formulário do Parecer : </label>
					<a href="{{route('download', ['file' => $trabalho->evento->formAvaliacaoExterno])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
						<img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
					</a>
					@if($trabalho->pivot->AnexoParecer == null)
						@component('componentes.input', ['label' => 'Anexo do Parecer'])
							<input type="file" class="form-control-file" id="exampleFormControlFile1" name="anexoParecer" required>
						@endcomponent

					@else
					<div class="form-row">
						<div class="col-md-12">
							<h6>Arquivo atual</h6>
						</div>
						<div class="col-md-12 form-group">
							<div>
								<a href="{{route('download', ['file' => $trabalho->pivot->AnexoParecer])}}" target="_new" style="font-size: 18px;;" class="btn btn-light">
									<img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px; margin:5px">
									Baixar arquivo atual
								</a>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12">
							<h6>Alterar arquivo atual</h6>
						</div>
						<div class="col-md-12 form-group">
							<div>
								<input type="file" class="form-control-file" id="exampleFormControlFile1" name="anexoParecer">
							</div>
						</div>
					</div>
					@endif
				
				</div>
				<div><hr></div>
				<div class="d-flex justify-content-end">
					<div style="margin-right: 15px"><a href="{{ route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id])}}"  class="btn btn-light" style="color: red;">Cancelar</a></div>
					<div><button type="submit" class="btn btn-success">Enviar meu parecer</button></div>
				</div>
			</form>
		  </div>
		</div>
	  </div>
	</div>

@endsection

@section('javascript')
<script type="text/javascript">


</script>
@endsection
