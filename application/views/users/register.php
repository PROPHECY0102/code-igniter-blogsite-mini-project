<div class="register-container">
  <div class="register-header-container">
    <h1 class="register-heading">Sign Up to Blogsite</h1>
    <p class="register-subheading">Registration requires a unique username, your email and a password.</p>
  </div>
  <div class="form-container">
    <form action="<?php echo base_url("users/register"); ?>" method="POST" class="register-form">
      <div class="register-username-container">
        <label for="username" class="register-username-label register-labels">Username:</label>
        <input type="text" name="username" class="register-username-field register-fields" placeholder="Username">
      </div>
      <div class="register-email-container">
        <label for="email" class="register-email-label register-labels">Email:</label>
        <input type="text" name="email" class="register-email-field register-fields" placeholder="Email">
      </div>
      <div class="register-password-container">
        <label for="password" class="register-password-label register-labels">Password:</label>
        <input type="password" name="password" class="register-password-field register-fields" placeholder="Password">
      </div>
      <div class="register-confirm-password-container">
        <label for="confirm_password" class="register-confirm-password-label register-labels">Confirm Password:</label>
        <input type="password" name="confirm_password" class="register-confirm-password-field register-fields" placeholder="Confirm Password">
      </div>
      <div class="register-submit-container">
        <input type="submit" value="Register" class="btn-submit-register">
      </div>
    </form>
  </div>
</div>