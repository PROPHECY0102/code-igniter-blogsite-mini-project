<script type="module" src="<?= base_url("assets/js/posts/view.js"); ?>"></script>

<div class="post-view-container">
  <h1 class="post-view-header"><?= $post["title"] ?></h1>
  <div class="post-view-content-container">
    <p class="post-view-content">
      <?= $post["content"] ?>
    </p>
    <p class="post-view-created-at">Created at: <?= $post["created_at"] ?></p>

  </div>
  <button class="btn-delete-post" data-post-id="<?= $post["id"] ?>">delete Post</button>
</div>