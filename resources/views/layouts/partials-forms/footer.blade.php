<footer>
    @if (Request::segment(3) === 'informacion'):
    <div class="pre-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="img-fluid img-responsive" src="{{ asset('assets/images/preciosblp.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="semi-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 text-center">
                    <img class="img-fluid img-responsive" src="{{ asset('assets/images/mapa.jpeg') }}" alt="">
                </div>
                <div class="col-sm-12 col-md-6 text-center">
                    <p>Dirección: Centro de las Campanas 3 Despacho 304  Torre A, San Andrés Alenco, 54040</p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 text-center text-md-left text-lg-left">
                    <p>© <?=date('Y')?> BLINDAJE LEGAL PATRIMONIAL</p>
                </div>
                <div class="col-sm-12 col-md-6 text-center text-md-right text-lg-right">
                    <ul class="footer-nav">
                        <li class="footer-item">
                            <a href="https://m.facebook.com/BlindajeLegalPatrimonial/" target="_blank" class="social"><i class="icon-social-facebook"></i></a>
                        </li>
                        <li class="footer-item">
                            <a href="https://api.whatsapp.com/send?phone=+525536195303" target="_blank" class="social"><i class="zmdi zmdi-whatsapp"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>