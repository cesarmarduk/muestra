@csrf
@if (Request::segment(4) === 'editar' OR Request::segment(4) === 'actualizar')
    @method('PUT')
@endif
@if ($errors->all())
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li><strong>{{ $error }}</strong></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif