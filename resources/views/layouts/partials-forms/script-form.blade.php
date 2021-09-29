<script type="text/javascript">
    $(function() {
        $('.fiador,.guarantor').hide();
        calculatorDays();
        calculatorYears();

        if (window.history.replaceState) { // verificamos disponibilidad
            window.history.replaceState(null, null, window.location.href);
        }
        
        $('[data-toggle="tooltip"]').tooltip()
        
        $("body").on( "click", ".addArrendador", function() {
           let item=Math.round(Math.random()*10000000000000);
           let html=`<div class="row arrendador_${item}">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <span class="p-b-59">
                            <a href="javascript:void(0)" data-id="${item}" class="deleteArrendador"><h4>Eliminar Arrendador</h4></a>  
                        </span>
                    </div>
                </div>  
                <div class="col-md-12">
                    <div class="form-group">
                        <span class="p-b-59 text-center">
                            <h4><strong>Datos del Arrendador</strong></h4>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="owner_type">Tipo de Arrendador</label>
                    <select class="form-control form-control-lg owner_type" name="owner_type[]" data-id="${item}">
                        <option value="Fisico">Persona Física</option>
                        <option value="Moral">Persona Moral (empresa)</option>
                    </select>
                </div>
            </div>
            <div class="row arrendador_${item}">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" name="owner_name[]" class="form-control form-control-lg">
                        <label class="arrendadorFisico${item}">Nombre completo</label>
                        <label class="arrendadorMoral${item}" style="display: none">Nombre o Razón social</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_email[]">
                        <label for="owner_email">Email</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="number" class="form-control form-control-lg" name="owner_phone[]">
                        <label for="owner_phone">Télefono</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 arrendadorMoral${item}" style="display:none">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_rfc[]">
                        <label for="owner_rfc">RFC</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <span class="p-b-59 text-center">
                            <h4><strong>Domicilio del Arrendador</strong></h4>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_address[]">
                        <label for="owner_address">Dirección</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_exterior[]">
                        <label for="owner_exterior">Número Exterior</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_interior[]">
                        <label for="owner_interior">Número Interior</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_colonia[]">
                        <label for="owner_colonia">Colonia</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_postal_code[]">
                        <label for="owner_postal_code">Código Postal</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group"> 
                        <label for="">Estado</label>
                        <select name="owner_state" class="form-control states state${item}" data-id="${item}">
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group"> 
                        <label for="">Municipio</label>
                        <select name="owner_municipality[]" class="form-control" id="city_id${item}">
                        </select>
                    </div>
                </div>
            </div>`;

            $('.contenedorArrendador').before(html); 
            states(item);         
        });

        $("body").on("click", ".deleteArrendador", function() {
            let id=$(this).attr('data-id');
            $(`.arrendador_${id}`).remove();
        });

        $("body").on( "click", ".addArrendatario", function() {
            let item=Math.round(Math.random()*10000000000000);
            let html=`<div class="row arrendatario_${item}">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <span class="p-b-59">
                            <a href="javascript:void(0)" data-id="${item}" class="deleteArrendatario"><h4>Eliminar Arrendatario</h4></a>  
                        </span>
                    </div>
                </div> 
                <div class="col-md-12">
                    <div class="form-group">
                        <span class="p-b-59 text-center">
                            <h4><strong>Datos del Arrendatario</strong></h4>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="tenant_type">Tipo de Arrendatario</label>
                    <select class="form-control form-control-lg tenant_type" name="tenant_type[]" data-id="${item}">
                        <option value="Fisico">Persona Física</option>
                        <option value="Moral">Persona Moral (empresa)</option>
                    </select>
                </div>
            </div>
            <div class="row arrendatario_${item}">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" name="tenant_name[]" class="form-control form-control-lg">
                        <label class="arrendatarioFisico${item}">Nombre completo</label>
                        <label class="arrendatarioMoral${item}" style="display: none">Nombre o Razón social</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_email[]">
                        <label for="tenant_email">Email</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="number" class="form-control form-control-lg" name="tenant_phone[]">
                        <label for="tenant_phone">Télefono</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 arrendatarioMoral${item}" style="display:none">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_rfc[]">
                        <label for="tenant_rfc">RFC</label>
                    </div>
                </div>
            </div>`;

            $('.contenedorArrendatario').before(html);
        });

        $("body").on("click", ".deleteArrendatario", function() {
            let id=$(this).attr('data-id');
            $(`.arrendatario_${id}`).remove();
        });
        
        $("body").on( "click", ".addObligado", function() {
            let item=Math.round(Math.random()*10000000000000);
            let html=`<div class="row guarantor obligado_${item}">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <span class="p-b-59">
                            <a href="javascript:void(0)" data-id="${item}" class="deleteGuarantor"><h4>Eliminar Arrendatario</h4></a>  
                        </span>
                    </div>
                </div> 
                <div class="col-md-12">
                    <div class="form-group">
                        <span class="p-b-59 text-center">
                            <h4><strong>Datos del Obligado Solidario y/o Fiador</strong></h4>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="guarantor_type">Tipo de Obligado Solidario y/o Fiador</label>
                    <select class="form-control form-control-lg guarantor_type" name="guarantor_type[]" data-id="${item}">
                        <option value="Fisico">Persona Física</option>
                        <option value="Moral">Persona Moral (empresa)</option>
                    </select>
                </div>
            </div>
            <div class="row guarantor obligado_${item}">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" name="guarantor_name[]" class="form-control form-control-lg">
                        <label class="guarantorFisico${item}">Nombre completo</label>
                        <label class="guarantorMoral${item}" style="display: none">Nombre o Razón social</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="guarantor_email[]">
                        <label for="guarantor_email">Email</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="number" class="form-control form-control-lg" name="guarantor_phone[]">
                        <label for="guarantor_phone">Télefono</label>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 guarantorMoral${item}" style="display:none">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="guarantor_rfc[]">
                        <label for="guarantor_rfc">RFC</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <span class="p-b-59 text-center">
                            <h4><strong>Domicilio del Obligado Solidario y/o Fiador</strong></h4>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="guarantor_address[]">
                        <label for="guarantor_address">Dirección</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="guarantor_exterior[]">
                        <label for="guarantor_exterior">Número Exterior</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="guarantor_interior[]">
                        <label for="guarantor_interior">Número Interior</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="guarantor_colonia[]">
                        <label for="guarantor_colonia">Colonia</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="guarantor_postal_code[]">
                        <label for="guarantor_postal_code">Código Postal</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group"> 
                        <label for="">Estado</label>
                        <select name="guarantor_state" class="form-control states state${item}" id="guarantor_state${item}" data-id="${item}">
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group"> 
                        <label for="">Municipio</label>
                        <select name="guarantor_municipality[]" class="form-control" id="city_id${item}">
                        </select>
                    </div>
                </div>
            </div>
            <div class="row fiador obligado_${item} fiador${item}" style="display:none">
                <div class="col-md-12">
                    <div class="form-group">
                        <span class="p-b-59 text-center">
                            <h4><strong>Datos Notariales</strong></h4>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="notarial_address[]">
                        <label for="notarial_address">Dirección</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="notarial_writing[]">
                        <label for="notarial_writing">Escritura</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="notarial_volume[]">
                        <label for="notarial_volume">Volumen</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="notarial_book[]">
                        <label for="notarial_book">Libro</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="notarial_notary[]">
                        <label for="notarial_notary">Notario</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="notarial_invoice[]">
                        <label for="notarial_invoice">Folio</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="notarial_place[]">
                        <label for="notarial_place">Lugar</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="">Fecha</label><br>
                    <select name="notarial_day[]" class="form-control day" style="width: 30% !important; float:left">
                    </select>
                    <select name="notarial_mounth[]" class="form-control" style="width: 30% !important; float:left">
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                    <select name="notarial_year[]" class="form-control year" style="width: 40% !important; float:left">
                    </select>
                </div>
            </div>`;

            $('.contenedorGuarantor').before(html);

            calculatorDays();
            calculatorYears();
            states(item);
        });

        $("body").on("click", ".deleteGuarantor", function() {
            let id=$(this).attr('data-id');
            $(`.obligado_${id}`).remove();
        });

        $("body").on("change", ".owner_type", function() {
            let item=$(this).attr('data-id');
            if($(this).val() === 'Fisico'){
                $(`.arrendadorFisico${item}`).show('fast');
                $(`.arrendadorMoral${item}`).hide('fast');
            }else{
                $(`.arrendadorFisico${item}`).hide('fast');
                $(`.arrendadorMoral${item}`).show('fast');
            }
        });

        $("body").on("change", ".tenant_type", function() {
            let item=$(this).attr('data-id');
            if($(this).val() === 'Fisico'){
                $(`.arrendatarioFisico${item}`).show('fast');
                $(`.arrendatarioMoral${item}`).hide('fast');
            }else{
                $(`.arrendatarioFisico${item}`).hide('fast');
                $(`.arrendatarioMoral${item}`).show('fast');
            }
        });
        
        $("body").on("change", ".guarantor_type", function() {
            let item=$(this).attr('data-id');
            if($(this).val() === 'Fisico'){
                $(`.guarantorFisico${item}`).show('fast');
                $(`.guarantorMoral${item}`).hide('fast');
                if($('#fiador_type1').prop('checked') === true){
                    $(`.fiador${item}`).hide('fast');
                } else {
                    $(`.fiador${item}`).show('fast');
                }
            }else{
                $(`.guarantorFisico${item}`).hide('fast');
                $(`.guarantorMoral${item}`).show('fast');
                if($('#fiador_type1').prop('checked') === true){
                    $(`.fiador${item}`).show('fast');
                } else {
                    $(`.fiador${item}`).hide('fast');
                }
            }
        });

        $("body").on("change", ".guarantor_type", e => detectarFisico());
        
        $("body").on("click", "#fiador_type1", function() {
            $(`.guarantor`).show('fast');
            $(`.fiador`).show('fast');
            detectarFisico();
        });
        
        $("body").on("click", "#fiador_type2", function() {
            $(`.guarantor`).show('fast');
            $(`.fiador`).hide('fast');
            detectarFisico();
        });
        
        $("body").on("click", "#fiador_type3", e => $(`.guarantor, .fiador`).hide('fast'));
    });

    let calculatorDays = () => {
        let rows;
        for(var x = 1; x <= 31; x++){
            rows += `<option value="${x}">${x}</option>`;
        }

        $('.day').html(rows);
    }
    
    let calculatorYears = () => {
        var fecha   = new Date();
        var ano     = parseInt(fecha.getFullYear()) + parseInt(50);
        let rows;

        for(var z = ano; z >= 1900; z--){
            rows += `<option value="${z}">${z}</option>`;
        }

        $('.year').html(rows);
        $('.year').val(fecha.getFullYear());
    }

    let detectarFisico = () => {
        if($('.guarantor_type').val() === 'Fisico'){
            $(`.fiadorFisico`).show('fast');
            $(`.fiadorMoral`).hide('fast');
        }else{
            $(`.fiadorFisico`).hide('fast');
            $(`.fiadorMoral`).show('fast');
        }
    }
</script>