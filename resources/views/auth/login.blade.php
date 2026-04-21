<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #039dff, #005fc3, #00416a);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,.2);
            background-color: #fff;
        }

        .login-card .card-body {
            padding: 40px;
        }

        .logo img {
            width: 150px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        .card-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .btn-warning {
            background: linear-gradient(135deg, #039dff, #005fc3, #00416a);
            border-color: #ff7a18;
            color: white;
            font-weight: bold;
            border-radius: 10px;
        }

        .btn-warning:hover {
            background-color: #ffb347;
            border-color: #ffb347;
        }

        .alert {
            margin-bottom: 20px;
            border-radius: 8px;
        }

        /* Additional Responsiveness */
        @media (max-width: 768px) {
            .login-card {
                width: 90%;
                padding: 20px;
            }

            .logo img {
                width: 120px;
            }

            .form-control {
                padding: 12px;
            }

            .btn-warning {
                font-size: 14px;
            }
        }

        /* Styling for the title */
        .card-header h4 {
            color: #0a2540; /* Blue color */
            font-weight: bold;
        }

        .card-header h4 span {
            color: #039dff; /* Blue color */
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="card login-card">
    <div class="card-body">
        <div class="logo">
            <!-- Logo Eazy di atas form login -->
            <img src="{{ asset('assets/img/logo_eazy.png') }}" alt="Eazy Cleaner Logo">
        </div>

        <div class="card-header">
            <h4 class="fw-bold">LOGIN ADMIN <span> EAZY CLEAN</span></h4>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-warning w-100">LOGIN</button>
        </form>
    </div>
</div>

</body>
</html>
