<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ecf0f1;
        }

        .container {
            width: 700px;
            height: 400px;
            margin: 80px auto;
            display: flex;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border-radius: 10px;
            overflow: hidden;
            background: white;
        }

        .left {
            width: 40%;
            background: #0f766e;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left h2 {
            margin-top: 10px;
        }

        .right {
            width: 60%;
            padding: 40px;
        }

        .right h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0f766e;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-bottom: 1px solid #ccc;
            outline: none;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #0f766e;
            border: none;
            color: white;
            border-radius: 20px;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.3s;
        }

        button:hover {
            background: #0d5c58;
        }

        .error {
            background: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
        }

        .success {
            background: #2ecc71;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #555;
        }

        .show-password {
            font-size: 13px;
            margin-top: 5px;
            color: #555;
        }

        .show-password input {
            width: auto;
            margin-right: 5px;
        }

        .ganti-password {
            text-align: center;
            margin-top: 15px;
        }

        .ganti-password a {
            color: #0f766e;
            text-decoration: none;
            font-size: 14px;
        }

        .ganti-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    
    <div class="left">
        <h1>📦</h1>
        <h2>Inventory App</h2>
        <p>Your Company</p>
    </div>

    <div class="right">

        <h2>Log In</h2>

        <?php if(session('error')): ?>
            <div class="error">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="/login">
            <?php echo csrf_field(); ?>

            <input 
                type="email" 
                name="email" 
                placeholder="Email"
                required
            >

            <input 
                type="password" 
                name="password" 
                placeholder="Password"
                id="password"
                required
            >

            <div class="show-password">
                <label>
                    <input type="checkbox" onclick="togglePassword()">
                    Tampilkan Password
                </label>
            </div>

            <button type="submit">
                Login
            </button>
        </form>

        <!-- LINK GANTI PASSWORD -->
        <div class="ganti-password">
            <a href="/ganti-password">
                Ganti Password
            </a>
        </div>

        <div class="footer">
            Inventory System © <?php echo e(date('Y')); ?>

        </div>

    </div>

</div>

<script>
function togglePassword() {
    let password = document.getElementById('password');

    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}
</script>

</body>
</html><?php /**PATH C:\Laravel10\TokoObat\resources\views/auth/login.blade.php ENDPATH**/ ?>