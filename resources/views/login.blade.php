<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Login | Ludiflex</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #ececec;
        }

        /*------------ Login container ------------*/

        .box-area {
            width: 930px;
        }

        /*------------ Right box ------------*/

        .right-box {
            padding: 40px 30px 40px 40px;
        }

        /*------------ Custom Placeholder ------------*/

        ::placeholder {
            font-size: 16px;
        }

        .rounded-4 {
            border-radius: 20px;
        }

        .rounded-5 {
            border-radius: 30px;
        }


        /*------------ For small screens------------*/

        @media only screen and (max-width: 768px) {

            .box-area {
                margin: 0 10px;

            }

            .left-box {
                height: 100px;
                overflow: hidden;
            }

            .right-box {
                padding: 20px;
            }

        }

        #loader-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        @media only screen and (max-width: 768px) {
            .box-area {
                margin: 0 10px;
            }

            .left-box {
                height: 100px;
                overflow: hidden;
            }

            .right-box {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div id="loader-overlay">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
        <p class="mt-3 fw-semibold text-primary">Antosan Kedap...</p>
    </div>

    <!----------------------- Main Container -------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Login Container -------------------------->

        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <!--------------------------- Left Box ----------------------------->

            <div class="col-md-6 d-flex justify-content-center align-items-center flex-column p-5 rounded-4 shadow"
                style="background: #5656f0; position: relative; overflow: hidden;">
                <!-- Decorative Elements -->
                <div
                    style="position: absolute; top: -40px; right: -40px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;">
                </div>
                <div
                    style="position: absolute; bottom: -40px; left: -40px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;">
                </div>

                <div class="featured-image mb-4">
                    <img src="{{ asset('images/smk1.JPG') }}" class="img-fluid rounded-4 shadow-lg"
                        style="width: 320px; transition: all 0.4s ease;"
                        onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                </div>
                <p class="text-white fs-6 fw-bold mb-2"
                    style="font-family: 'Poppins', sans-serif; letter-spacing: 1px;">TATA RIKSA K-ONE</p>
                <small class="text-white text-center d-block"
                    style="max-width: 18rem; font-family: 'Poppins', sans-serif; font-size: 0.9rem; line-height: 1.6;">
                    Siap berkarir dengan pengalaman magang terbaik.
                </small>
            </div>

            <!-------------------- ------ Right Box ---------------------------->

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Selamat Datang !</h2>
                        <p>Masuk untuk mulai pengalaman PKL-mu</p>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="login-form" action="" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" value="{{ old('nip') }}" name="nip"
                                class="form-control form-control-lg bg-light fs-6"
                                placeholder="Masukkan NIS / NIP / Email">
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Password">
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            {{-- <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Ingatkan
                                        Saya</small></label>
                            </div> --}}
                            {{-- <div class="forgot">
                                <small><a href="#">Forgot Password?</a></small>
                            </div> --}}
                        </div>
                        <div class="input-group mb-3">
                            <button id="login-btn" class="btn btn-lg btn-primary w-100 fs-6" type="submit"
                                style="background-color: #5656f0">
                                Masuk
                            </button>
                        </div>
                        <div class="input-group mb-3">
                            <a href="/" type="button" class="btn btn-lg btn-light w-100 fs-6">Kembali</a>
                        </div>
                        {{-- <div class="input-group mb-3">
                            <button class="btn btn-lg btn-light w-100 fs-6"><img src="images/google.png"
                                    style="width:20px" class="me-2"><small>Sign In with Google</small></button>
                        </div> --}}
                        {{-- <div class="row">
                            <small>Don't have account? <a href="#">Sign Up</a></small>
                        </div> --}}
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        const form = document.getElementById('login-form');
        const loader = document.getElementById('loader-overlay');
        const loginBtn = document.getElementById('login-btn');

        form.addEventListener('submit', function () {
            loader.style.display = 'flex';
            loginBtn.disabled = true;
        });
    </script>
</body>

</html>