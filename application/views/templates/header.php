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

    <div class="header-register-login">
      <a class="link-register btn-style" href="<?php echo base_url("users/register"); ?>">Register</a>
      <a class="link-login btn-style" href="<?php echo base_url("users/login"); ?>">Login</a>
    </div>

  </header>