<div class="modal effect-flip-vertical" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title text-transform-initial" id="permissionsTitle"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="search">Búsqueda</label>
                            <input type="text" class="form-control border-light" name="search" id="search" placeholder="Ingresa la búsqueda...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="pagination" id="pagination">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-9">
                        <div class="form-group">
                            <div class="pag float-right">

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-centered table-bordered table-hover text-md-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0 text-justify" width="100%">Permisos</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyGeneral">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3"></div>
                    <div class="col-sm-8 col-md-9">
                        <div class="form-group">
                            <div class="pag float-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="rol">
                <button class="btn btn-md ripple btn-danger waves-effect waves-dark" data-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>