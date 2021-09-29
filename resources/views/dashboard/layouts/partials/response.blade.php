@csrf
@if (isset($response))
    <div class="row">
        <div class="col-sm-12 margin-bottom10">
            <div class="alert alert-danger">
                <ul>
                    <li><strong>{{ $response['message'] }}</strong></li>
                </ul>
            </div>
        </div>
    </div>
@endif