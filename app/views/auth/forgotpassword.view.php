<h2>Forgot Password</h2>
<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<form method="post" action="<?= ROOT ?>/forgotpassword/sendreset">
  <div class="form-floating mb-3">
    <input type="email" name="email" class="form-control" placeholder="Email address" required>
    <label>Email address</label>
  </div>
  <button type="submit" class="btn btn-primary">Send reset link</button>
</form>
