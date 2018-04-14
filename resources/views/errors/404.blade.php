@extends('layouts.master')
@section('title')
    Błąd
@endsection

@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="row">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center text-center error-page bg-dark">
                    <div class="col-lg-7 mx-auto text-white">
                        <div class="row align-items-center d-flex flex-row">
                            <img class="mx-auto" src="img/logo-admin.png" alt="logo">
                        </div>
                        <div class="row align-items-center d-flex flex-row">
                            <div class="col-lg-6 text-lg-right pr-lg-4">
                                <h1 class="display-1 mb-0">404</h1>
                            </div>
                            <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                                <h2>Błędny adres!</h2>
                                <h3 class="font-weight-light">Bardzo nam przykro, ale podana strona nie istnieje.</h3>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 text-center mt-xl-2">
                                <a class="text-white font-weight-medium" href="{{ URL::to('dashboard') }}">Wróć do aplikacji</a>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 mt-xl-2">
                                <p class="text-white font-weight-medium text-center">Copyright &copy; 2018 <span class="text-primary">ESKULAP</span>. All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
