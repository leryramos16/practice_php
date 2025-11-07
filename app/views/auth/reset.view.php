<h2>Reset Password</h2>
<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<form method="post" action="<?= ROOT ?>/forgotpassword/reset">
  <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
  <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

  <div class="form-floating mb-3">
    <input type="password" name="password" class="form-control" placeholder="New password" required>
    <label>New password (min 8 chars)</label>
  </div>

  <div class="form-floating mb-3">
    <input type="password" name="password_confirm" class="form-control" placeholder="Confirm password" required>
    <label>Confirm password</label>
  </div>

  <button type="submit" class="btn btn-primary">Change password</button>
</form>
