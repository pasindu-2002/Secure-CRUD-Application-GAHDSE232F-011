<form action="http://localhost/Secure-CRUD/public/index.php?action=reset_password" method="POST">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

    <div class="form-group">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required>
    </div>

    <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
    </div>

    <button type="submit" class="btn btn-primary">Reset Password</button>
</form>
