@extends('layouts.app')
@section('content')

    <div class="login-page">
        <div class="login-card">

            <div class="logo-box">
                <img src="{{ URL::to('assets/img/logo.png') }}" alt="Logo" class="logo-img">
            </div>

            <h2 class="title">Welcome Back</h2>
            <p class="subtitle">Login to your account</p>

            {!! Toastr::message() !!}

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group mb-3">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email" value="{{ old('email') }}" required autocomplete="off">
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" required autocomplete="off">
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>

            </form>

        </div>
    </div>

    <style>
        .login-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #eceff4 0%, #dfe3e8 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-card {
            width: 380px;
            padding: 35px;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .logo-box {
            margin-bottom: 20px;
        }

        .logo-img {
            width: 120px;
            height: auto;
            object-fit: contain;
        }

        .title {
            font-size: 26px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 25px;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
        }

        .btn-primary {
            height: 48px;
            border-radius: 10px;
            background: #044e38;
            border: none;
            font-weight: 600;
            color: #fff;
        }

        .btn-primary:hover {
            background: #044e38;
        }
    </style>

@endsection