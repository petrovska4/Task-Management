<?php 
session_start();
include_once "../header.php"; 

$errorMessage = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Sign In</h2>
                    <form action="../../controllers/login.php" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input 
                                type="text" 
                                class="form-control <?php echo $errorMessage ? 'is-invalid' : ''; ?>" 
                                id="username" 
                                name="username" 
                                placeholder="Enter your username" 
                                value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>" 
                                required
                            >
                            <div class="invalid-feedback">Please enter your username.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input 
                                type="password" 
                                class="form-control <?php echo $errorMessage ? 'is-invalid' : ''; ?>" 
                                id="password" 
                                name="password" 
                                placeholder="Enter your password" 
                                required
                            >
                            <?php if ($errorMessage): ?>
                                <div class="invalid-feedback d-block"><?php echo $errorMessage; ?></div>
                            <?php else: ?>
                                <div class="invalid-feedback">Please enter your password.</div>
                            <?php endif; ?>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Log In</button>
                            <a href="register_index.php" class="btn btn-outline-success btn-lg">Sign Up</a>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <a href="#" class="text-muted">Forgot password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        'use strict';
        document.addEventListener('DOMContentLoaded', function () {
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    })();
</script>

<?php include_once "../footer.php"; ?>
