<div class="posts-container">
  <div class="posts-list-header-container">
    <h1 class="posts-list-header">Showing Latest Posts</h1>
    <a class="post-link" href="<?= base_url("/posts/seed") ?>">Seed Random Posts</a>
  </div>
  <p>Total posts: <?= count($posts) ?></p>
  <div class="posts-list">
    <?php foreach ($posts as $index => $post): ?>
      <div class="post-container">
        <h2 class="post-title"><?= ($index + 1) ?>. <?= $post["title"] ?></h2>
        <p class="post-content">
          <?= $post["content"] ?>
        </p>
        <div class="post-subsection">
          <p class="post-created-at">Created at: <?= $post["created_at"] ?></p>
          <a class="post-link" href="<?= base_url("/posts/{$post["slug"]}") ?>">View Post</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>