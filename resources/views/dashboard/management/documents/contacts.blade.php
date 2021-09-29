@extends('dashboard.layouts.app')

@section('title')
Firmantes | {{ $document->description }} - Documentos
@endsection

@section('content')
<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">@yield('title')</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@if(count($documents_firms) > 0)
<div class="row row-sm">
    @foreach($documents_firms as $document_firm)
    <div class="col-xl-4 col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-heder">{{ $document_firm->contact->fullname }}</h4>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 margin-bottom10">
                            <div class="from-group">
                                <h6 class="text-transform-initial"><strong>Email: </strong> {{ $document_firm->contact->email }}</h6>
                            </div>
                            <div class="from-group">
                                <h6 class="text-transform-initial"><strong>IP: </strong> {{ $document_firm->ip }}</h6>
                            </div>
                        </div>
                        <div class="col-sm-12 margin-bottom10">
                            @php
                                if ($document_firm->variables_status === 'Solicitud'): 
                                    $icon_var   = 'launch';
                                    $color_var  = 'default';
                                elseif ($document_firm->variables_status === 'Proceso'): 
                                    $icon_var   = 'launch';
                                    $color_var  = 'warning';
                                elseif ($document_firm->variables_status === 'Finalizado'): 
                                    $icon_var   = 'check_circle_outline';
                                    $color_var  = 'info';
                                elseif ($document_firm->variables_status === 'Aprobado'): 
                                    $icon_var   = 'check_circle_outline';
                                    $color_var  = 'success';
                                elseif ($document_firm->variables_status === 'Rechazado'): 
                                    $icon_var   = 'close';
                                    $color_var  = 'yellow';
                                elseif ($document_firm->variables_status === 'Cancelado'): 
                                    $icon_var   = 'close';
                                    $color_var  = 'danger';
                                endif;
                            @endphp 
                            <div class="from-group">
                                <h6 class="text-transform-initial"><strong>Estatus Variables</strong></h6>
                            </div>
                            <div class="from-group">
                                <div class="status-bar">
                                    <div class="status-bar-icon bg-{{ $color_var }}"><i class="material-icons">{{ $icon_var }}</i></div>
                                    <div class="status-bar-info">{{ $document_firm->variables_status }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 margin-bottom10">
                            @php
                                if ($document_firm->photo_profile_status === 'Solicitud'): 
                                    $icon_pro   = 'launch';
                                    $color_pro  = 'default';
                                elseif ($document_firm->photo_profile_status === 'Proceso'): 
                                    $icon_pro   = 'launch';
                                    $color_pro  = 'warning';
                                elseif ($document_firm->photo_profile_status === 'Finalizado'): 
                                    $icon_pro   = 'check_circle_outline';
                                    $color_pro  = 'info';
                                elseif ($document_firm->photo_profile_status === 'Aprobado'): 
                                    $icon_pro   = 'check_circle_outline';
                                    $color_pro  = 'success';
                                elseif ($document_firm->photo_profile_status === 'Rechazado'): 
                                    $icon_pro   = 'close';
                                    $color_pro  = 'yellow';
                                elseif ($document_firm->photo_profile_status === 'Cancelado'): 
                                    $icon_pro   = 'close';
                                    $color_pro  = 'danger';
                                endif;
                            @endphp 
                            <div class="from-group">
                                <h6 class="text-transform-initial"><strong>Estatus Foto Perfil</strong></h6>
                            </div>
                            <div class="from-group">
                                <div class="status-bar">
                                    <div class="status-bar-icon bg-{{ $color_pro }}"><i class="material-icons">{{ $icon_pro }}</i></div>
                                    <div class="status-bar-info">{{ $document_firm->photo_profile_status }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 margin-bottom10">
                            @php
                                if ($document_firm->photo_dni_status === 'Solicitud'): 
                                    $icon_dni   = 'launch';
                                    $color_dni  = 'default';
                                elseif ($document_firm->photo_dni_status === 'Proceso'): 
                                    $icon_dni   = 'launch';
                                    $color_dni  = 'warning';
                                elseif ($document_firm->photo_dni_status === 'Finalizado'): 
                                    $icon_dni   = 'check_circle_outline';
                                    $color_dni  = 'info';
                                elseif ($document_firm->photo_dni_status === 'Aprobado'): 
                                    $icon_dni   = 'check_circle_outline';
                                    $color_dni  = 'success';
                                elseif ($document_firm->photo_dni_status === 'Rechazado'): 
                                    $icon_dni   = 'close';
                                    $color_dni  = 'yellow';
                                elseif ($document_firm->photo_dni_status === 'Cancelado'): 
                                    $icon_dni   = 'close';
                                    $color_dni  = 'danger';
                                endif;
                            @endphp 
                            <div class="from-group">
                                <h6 class="text-transform-initial"><strong>Estatus Foto @if ($document_firm->dni_type === 'Pasaporte') del Pasporte @else de la Identificación (Frontal) @endif</strong></h6>
                            </div>
                            <div class="from-group">
                                <div class="status-bar">
                                    <div class="status-bar-icon bg-{{ $color_dni }}"><i class="material-icons">{{ $icon_dni }}</i></div>
                                    <div class="status-bar-info">{{ $document_firm->photo_dni_status }}</div>
                                </div>
                            </div>
                        </div>
                        @if ($document_firm->dni_type !== 'Pasaporte') 
                        <div class="col-sm-12 margin-bottom10">
                            @php
                                if ($document_firm->photo_dni_reverse_status === 'Solicitud'): 
                                    $icon_dnir  = 'launch';
                                    $color_dnir = 'default';
                                elseif ($document_firm->photo_dni_reverse_status === 'Proceso'): 
                                    $icon_dnir  = 'launch';
                                    $color_dnir = 'warning';
                                elseif ($document_firm->photo_dni_reverse_status === 'Finalizado'): 
                                    $icon_dnir  = 'check_circle_outline';
                                    $color_dnir = 'info';
                                elseif ($document_firm->photo_dni_reverse_status === 'Aprobado'): 
                                    $icon_dnir  = 'check_circle_outline';
                                    $color_dnir = 'success';
                                elseif ($document_firm->photo_dni_reverse_status === 'Rechazado'): 
                                    $icon_dnir  = 'close';
                                    $color_dnir = 'yellow';
                                elseif ($document_firm->photo_dni_reverse_status === 'Cancelado'): 
                                    $icon_dnir  = 'close';
                                    $color_dnir = 'danger';
                                endif;
                            @endphp 
                            <div class="from-group">
                                <h6 class="text-transform-initial"><strong>Estatus Foto de la Identificación (Reverso)</strong></h6>
                            </div>
                            <div class="from-group">
                                <div class="status-bar">
                                    <div class="status-bar-icon bg-{{ $color_dnir }}"><i class="material-icons">{{ $icon_dnir }}</i></div>
                                    <div class="status-bar-info">{{ $document_firm->photo_dni_reverse_status }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-sm-12 margin-bottom10">
                            @php
                                if ($document_firm->document === 'Sin Autorizar'): 
                                    $icon_doc   = 'launch';
                                    $color_doc  = 'default';
                                elseif ($document_firm->document === 'Autorizada'): 
                                    $icon_doc   = 'launch';
                                    $color_doc  = 'warning';
                                endif;
                            @endphp 
                            <div class="from-group">
                                <h6 class="text-transform-initial"><strong>Estatus del Documento</strong></h6>
                            </div>
                            <div class="from-group">
                                <div class="status-bar">
                                    <div class="status-bar-icon bg-{{ $color_doc }}"><i class="material-icons">{{ $icon_doc }}</i></div>
                                    <div class="status-bar-info">{{ $document_firm->document }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 margin-bottom10">
                            @php
                                if ($document_firm->firm_status === 'Solicitud'): 
                                    $icon_firm   = 'launch';
                                    $color_firm  = 'default';
                                elseif ($document_firm->firm_status === 'Proceso'): 
                                    $icon_firm   = 'launch';
                                    $color_firm  = 'warning';
                                elseif ($document_firm->firm_status === 'Finalizado'): 
                                    $icon_firm   = 'check_circle_outline';
                                    $color_firm  = 'info';
                                elseif ($document_firm->firm_status === 'Aprobado'): 
                                    $icon_firm   = 'check_circle_outline';
                                    $color_firm  = 'success';
                                elseif ($document_firm->firm_status === 'Rechazado'): 
                                    $icon_firm   = 'close';
                                    $color_firm  = 'yellow';
                                elseif ($document_firm->firm_status === 'Cancelado'): 
                                    $icon_firm   = 'close';
                                    $color_firm  = 'danger';
                                endif;
                            @endphp 
                            <div class="from-group">
                                <h6 class="text-transform-initial"><strong>Estatus de la Firma</strong></h6>
                            </div>
                            <div class="from-group">
                                <div class="status-bar">
                                    <div class="status-bar-icon bg-{{ $color_firm }}"><i class="material-icons">{{ $icon_firm }}</i></div>
                                    <div class="status-bar-info">{{ $document_firm->firm_status }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @php 
                    if($document_firm->status === 'Solicitud'):
                        $icon   = 'launch';
                        $color  = 'default';
                    elseif($document_firm->status === 'Proceso'):
                        $icon   = 'launch';
                        $color  = 'warning';
                    elseif($document_firm->status === 'Finalizado'):
                        $icon   = 'check_circle_outline';
                        $color  = 'info';
                    elseif($document_firm->status === 'Aprobado'):
                        $icon   = 'check_circle_outline';
                        $color  = 'success';
                    elseif($document_firm->status === 'Rechazado'):
                        $icon   = 'close';
                        $color  = 'yellow';
                    elseif($document_firm->status === 'Cancelado'):
                        $icon   = 'close';
                        $color  = 'danger';
                    endif;
                    @endphp
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="from-group">
                                <h6 class="text-transform-initial">Estatus General</h6>
                            </div>
                            <div class="from-group">
                                <div class="status-bar">
                                    <div class="status-bar-icon bg-{{ $color }}"><i class="material-icons">{{ $icon }}</i></div>
                                    <div class="status-bar-info">{{ $document_firm->status }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
            