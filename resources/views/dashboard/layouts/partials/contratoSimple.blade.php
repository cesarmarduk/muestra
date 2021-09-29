<script type="text/javascript">
    $(function() {
        $('.fiador').hide();
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
                            <a href="javascript:void(0)" data-id="${item}" class="deleteArrendador"><h3>Arrendador X</h3></a>  
                        </span>
                    </div>
                </div>  
                <div class="col-md-6">
                    <label for="owner_type">Tipo de Arrendador</label>
                    <select class="form-control form-control-lg owner_type" name="owner_type[]" data-id="${item}">
                        <option value="Fisico">Físico</option>
                        <option value="Moral">Moral</option>
                    </select>
                </div>
            </div>
            <div class="row arrendador_${item}">
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" name="owner_name[]" class="form-control form-control-lg" required="required">
                        <label class="arrendadorFisico${item}">Nombre completo</label>
                        <label class="arrendadorMoral${item}" style="display: none">Nombre o Razón social</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_email[]" required="required">
                        <label for="owner_email">Email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_phone[]" required="required">
                        <label for="owner_phone">Télefono</label>
                    </div>
                </div>
                <div class="col-md-6 arrendadorMoral${item}" style="display:none">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_rfc[]">
                        <label for="owner_rfc">RFC</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <span class="p-b-59 text-center">
                            <h4><strong>Domicilio Arrendador</strong></h4>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_type_road[]" required="required">
                        <label for="owner_type_road">Tipo de Vialidad</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_name_road[]" required="required">
                        <label for="owner_name_road">Nombre de la Vialidad</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_exterior[]" required="required">
                        <label for="owner_exterior">Número Exterior</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_interior[]">
                        <label for="owner_interior">Número Interior</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_colonia[]" required="required">
                        <label for="owner_colonia">Colonia</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_postal_code[]" required="required">
                        <label for="owner_postal_code">Código Postal</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_municipal[]" required="required">
                        <label for="owner_municipal">Municipio y/o Demarcación Territorial</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="owner_entity[]" required="required">
                        <label for="owner_entity">Entidad Federativa</label>
                    </div>
                </div>
            </div>`;

            $('.contenedorArrendador').before(html);          
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
                            <a href="javascript:void(0)" data-id="${item}" class="deleteArrendatario"><h3>Arrendatario X</h3></a>  
                        </span>
                    </div>
                </div> 
                <div class="col-md-6">
                    <label for="tenant_type">Tipo de Arrendatario</label>
                    <select class="form-control form-control-lg tenant_type" name="tenant_type[]" data-id="${item}">
                        <option value="Fisico">Físico</option>
                        <option value="Moral">Moral</option>
                    </select>
                </div>
            </div>
            <div class="row arrendatario_${item}">
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" name="tenant_name[]" class="form-control form-control-lg" required="required">
                        <label class="arrendatarioFisico${item}">Nombre completo</label>
                        <label class="arrendatarioMoral${item}" style="display: none">Nombre o Razón social</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_email[]" required="required">
                        <label for="tenant_email">Email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_phone[]" required="required">
                        <label for="tenant_phone">Télefono</label>
                    </div>
                </div>
                <div class="col-md-6 arrendatarioMoral${item}" style="display:none">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_rfc[]">
                        <label for="tenant_rfc">RFC</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <span class="p-b-59 text-center">
                            <h4><strong>Domicilio Arrendatario</strong></h4>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_type_road[]" required="required">
                        <label for="tenant_type_road">Tipo de Vialidad</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_name_road[]" required="required">
                        <label for="tenant_name_road">Nombre de la Vialidad</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_exterior[]" required="required">
                        <label for="tenant_exterior">Número Exterior</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_interior[]">
                        <label for="tenant_interior">Número Interior</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_colonia[]" required="required">
                        <label for="tenant_colonia">Colonia</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_postal_code[]" required="required">
                        <label for="tenant_postal_code">Código Postal</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_municipal[]" required="required">
                        <label for="tenant_municipal">Municipio y/o Demarcación Territorial</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <input type="text" class="form-control form-control-lg" name="tenant_entity[]" required="required">
                        <label for="tenant_entity">Entidad Federativa</label>
                    </div>
                </div>
            </div>`;

            $('.contenedorArrendatario').before(html);
        });

        $("body").on("click", ".deleteArrendatario", function() {
            let id=$(this).attr('data-id');
            $(`.arrendatario_${id}`).remove();
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

        $("body").on("change", ".guarantor_type", e => detectarFisico());
        
        $("body").on("click", "#fiador_type1", function() {
            $(`.sinFiador`).show('fast');
            $(`.fiador`).show('fast');
            detectarFisico();
        });
        
        $("body").on("click", "#fiador_type2", function() {
            $(`.sinFiador`).show('fast');
            $(`.fiador`).hide('fast');
            detectarFisico();
        });
        
        $("body").on("click", "#fiador_type3", e => $(`.sinFiador, .fiador`).hide('fast'));
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