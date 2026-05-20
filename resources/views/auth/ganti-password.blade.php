<!DOCTYPE html>
<html>
<head>
    <title>Ganti Password</title>

    <style>
        body{
            margin:0;
            font-family:Arial, sans-serif;
            background:#ecf0f1;
        }

        .card{
            width:400px;
            margin:80px auto;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            color:#0f766e;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:10px;
            margin:10px 0;
            border:none;
            border-bottom:1px solid #ccc;
            outline:none;
            box-sizing:border-box;
        }

        button{
            width:100%;
            padding:10px;
            background:#0f766e;
            border:none;
            color:white;
            border-radius:20px;
            cursor:pointer;
            margin-top:15px;
        }

        button:hover{
            background:#0d5c58;
        }

        .error{
            background:#e74c3c;
            color:white;
            padding:10px;
            border-radius:5px;
            margin-bottom:15px;
            text-align:center;
        }

        .success{
            background:#2ecc71;
            color:white;
            padding:10px;
            border-radius:5px;
            margin-bottom:15px;
            text-align:center;
        }

        a{
            display:block;
            text-align:center;
            margin-top:15px;
            color:#0f766e;
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="card">

    <h2>Ganti Password</h2>

    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form action="/ganti-password" method="POST">
    @csrf

    <input type="email"
           name="email"
           placeholder="Email"
           required>

    <input type="password"
           name="password_lama"
           placeholder="Password Lama"
           required>

    <input type="password"
           name="password_baru"
           placeholder="Password Baru"
           required>

    <button type="submit">
        Ganti Password
    </button>
</form>

    <a href="/login">
        ← Kembali ke Login
    </a>

</div>

</body>
</html>