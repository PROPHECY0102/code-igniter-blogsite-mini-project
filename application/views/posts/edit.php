<div class="publish-container">
  <div class="publish-header-container">
    <h1 class="publish-heading">Editing Post: <?php echo $post["title"]; ?></h1>
    <p class="publish-subheading">Both Title and Content can be modified.</p>
  </div>
  <div class="form-container">
    <form action="<?php echo base_url("posts/edit/$post_id"); ?>" method="POST">
      <div class="form-title-container">
        <label for="title" class="form-title-label">Title:</label>
        <input type="text" name="title" class="form-text-input" placeholder="Enter a post title" value="<?php echo $post["title"]; ?>">
      </div>
      <div class="form-content-container">
        <label for="content" class="form-content-label">Content:</label>
        <textarea name="content" class="form-text-input content-textarea" placeholder="Enter a post content"><?php echo $post["content"]; ?>
        </textarea>
      </div>
      <div class="form-post-image-container">
        <div class="form-post-image-header">
          <p class="current-image">
            <?php if (isset($post["image"])): ?>
              Current Image: <?php echo $post["image"]; ?>
            <?php else: ?>
              This post currently has no image.
            <?php endif; ?>
          </p>
          <?php if (isset($post["image"])): ?>
            <button type="button" class="btn-remove-image">Remove this image</button>
          <?php endif; ?>
        </div>
        <div class="form-preview-image-container">
          <?php if (isset($post["image"])): ?>
            <img src="<?php echo base_url("assets/images/posts/{$post['image']}"); ?>" alt="<?php echo $post["image"]; ?>" class="form-preview-image">
          <?php endif; ?>
        </div>
        <div class="form-image-container">
          <label for="post-image" class="form-image-label">Add or Edit the image of this post.</label>
          <input type="file" name="post-image" class="form-image-field">
        </div>
      </div>
      <div class="form-publish-container">
        <input type="submit" value="Edit" class="btn-submit-post">
      </div>
    </form>
  </div>
</div>