<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">

    <!-- Bootstrap (optional kalau belum ada di CSS kamu) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row main-content bg-success text-center">
            
            <div class="col-md-4 text-center company__info">
                <h4 class="company_title">Apotek Anda</h4>
            </div>

            <div class="col-md-8 col-xs-12 col-sm-12 login_form">
                <div class="container-fluid">
                    
                    <div class="row">
                        <h2>Log In</h2>
                    </div>

                    <!-- ERROR MESSAGE -->
                    <?php if(session('error')): ?>
                        <p style="color:red"><?php echo e(session('error')); ?></p>
                    <?php endif; ?>

                    <div class="row">
                        <form method="POST" action="/login" class="form-group">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <input 
                                    type="text" 
                                    name="name" 
                                    class="form__input" 
                                    placeholder="Nama"
                                    required
                                >
                            </div>

                            <div class="row">
                                <input 
                                    type="password" 
                                    name="password" 
                                    class="form__input" 
                                    placeholder="Password"
                                    required
                                >
                            </div>

                            <div class="row">
                                <input type="checkbox" name="remember" id="remember_me">
                                <label for="remember_me">Remember Me!</label>
                            </div>

                            <div class="row">
                                <input type="submit" value="Login" class="btn">
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid text-center footer">
        <p>Coded with ♥</p>
    </div>

</body>
</html><?php /**PATH C:\Laravel10\TokoObat\resources\views/login.blade.php ENDPATH**/ ?>