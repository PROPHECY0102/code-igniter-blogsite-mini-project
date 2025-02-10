<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <script type="module" src="<?= base_url("assets/js/script.js"); ?>"></script>
  <title>Blogsite | <?= $title ?></title>
</head>

<body>
  <input type="hidden" class="metadata" data-base-url="<?= base_url("") ?>">
  <header class="header">
    <div class="header-logo-nav">
      <a class="logo" href="<?= base_url("") ?>">BlogSite</a>
      <nav class="nav-section">
        <ul class="nav-links">
          <li class="nav-link"><a href="<?= base_url("") ?>">Home</a></li>
          <li class="nav-link"><a href="<?= base_url("about") ?>">About</a></li>
          <li class="nav-link"><a href="<?= base_url("posts") ?>">Posts</a></li>
          <li class="nav-link"><a href="<?= base_url("posts/publish") ?>">Publish</a></li>
        </ul>
      </nav>
    </div>

    <?php if ($auth["logged_in"]): ?>
      <div class="header-register-login">
        <h1 class="header-greeting-text">Welcome <?php echo $auth["user"]["username"]; ?></h1>
        <a href="<?php echo base_url("users/logout"); ?>" class="link-logout">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="currentColor" d="M5 5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h7v-2H5zm16 7l-4-4v3H9v2h8v3z" />
          </svg>
        </a>
      </div>
    <?php else: ?>
      <div class="header-register-login">
        <a class="link-register btn-style" href="<?php echo base_url("users/register"); ?>">Register</a>
        <a class="link-login btn-style" href="<?php echo base_url("users/login"); ?>">Login</a>
      </div>
    <?php endif; ?>





  </header>