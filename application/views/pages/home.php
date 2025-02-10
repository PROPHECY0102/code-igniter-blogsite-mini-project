<h1>Home</h1>

<?php if ($auth["logged_in"]): ?>
  <h1>Welcome <?php echo $auth["user"]["username"]; ?></h1>
<?php else: ?>
  <h1>User has not logged in</h1>
<?php endif; ?>