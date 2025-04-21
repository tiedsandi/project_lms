@extends('layouts.main')

@section('page-title', 'Login')
@section('content-layout')
<main>
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
            <div class="card mb-3">
              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">LMS PPKD</h5>
                  <p class="text-center small">Masukan Email dan Password anda</p>
                </div>

                <form class="row g-3 needs-validation" novalidatefg method="post" action="/action-login">
                  @csrf
                  <div class="col-12">
                    <label for="yourUsername" class="form-label">Email
                      <span class="text-danger small">*</span>
                    </label>
                    <div class="input-group has-validation">
                      <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="yourUsername" required>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password
                      <span class="text-danger small">*</span>
                    </label>
                    <input type="password" value="{{ old('password') }}" name="password" class="form-control" id="yourPassword" required>
                  </div>

                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit" name="login">Masuk</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
@endsection