<div class="modal effect-flip-vertical" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title text-transform-initial">Crear Dirección</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 addressName margin-bottom10">
                        <div class="alert alert-danger">
                            <ul class="addressNameUl">
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="addressName">Dirección</label>
                            <textarea cols="40" rows="6" autofocus class="form-control form-control-addressName" name="addressName" id="addressName" placeholder="Ingrese dirección"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-md btn-success waves-effect wave-dark right10" id="saveAddressBtn" type="submit"><i class="material-icons">save</i> Guardar</button>
                <button class="btn btn-md ripple btn-danger waves-effect wave-dark" data-dismiss="modal" type="button"><i class="material-icons">close</i> Cerrar</button>
            </div>
        </div>
    </div>
</div>