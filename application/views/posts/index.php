<div class="posts-container">
  <div class="posts-list-header-container">
    <h1 class="posts-list-header">Showing Latest Posts</h1>
    <a class="post-link" href="<?= base_url("/posts/seed") ?>">Seed Random Posts</a>
  </div>
  <p>Showing <?= count($posts) ?> posts. Total number of posts: <?php echo $total_count; ?></p>
  <div class="posts-list">
    <?php if (!empty($posts)): ?>
      <?php foreach ($posts as $index => $post): ?>
        <div class="post-container">
          <h2 class="post-title"><?= (($index + $offset) + 1) ?>. <?= $post["title"] ?></h2>
          <p class="post-content">
            <?php echo word_limiter($post["content"], 60, "..."); ?>
          </p>
          <div class="post-subsection">
            <div class="post-extra-details">
              <p class="post-belongs-user"><?php echo $post["username"]; ?></p>
              <p class="post-created-at">| Created at: <?= $post["created_at"] ?></p>
            </div>
            <a class="post-link" href="<?= base_url("/posts/view/{$post["slug"]}") ?>">View Post</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <h1>No Posts found.</h1>
    <?php endif; ?>
    <nav>
      <?= $pagination_links; ?>
    </nav>
  </div>
</div>