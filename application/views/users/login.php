<script type="module" src="<?= base_url("assets/js/users/login.js"); ?>"></script>
<div class="login-container">
  <div class="publish-header-container">
    <h1 class="publish-heading">Login</h1>
    <p class="publish-subheading">Both Username and Password Fields are required.</p>
  </div>
  <div class="form-container">
    <?php echo validation_errors(); ?>
    <?php echo form_open("users/login", ["class" => "login-form"]); ?>
    <input type="hidden" name="login_method" value="username" class="login-method">
    <div class="login-username-email-container">
      <label for="username" class="login-username-email-label">Username:</label>
      <input type="text" name="username" class="login-username-email-field login-fields" placeholder="Username">
    </div>
    <div class="login-password-container">
      <label for="password" class="login-password-label">Password:</label>
      <input type="password" name="password" class="login-password-field login-fields" placeholder="Password">
    </div>
    <div class="login-submit-container">
      <button type="button" class="btn-change-method">Use Email Instead</button>
      <input type="submit" value="Login" class="btn-submit-login">
    </div>
    </form>
  </div>
</div>