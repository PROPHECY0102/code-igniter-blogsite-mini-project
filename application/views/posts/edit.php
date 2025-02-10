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
      <div class="form-publish-container">
        <input type="submit" value="Edit" class="btn-submit-post">
      </div>
    </form>
  </div>
</div>