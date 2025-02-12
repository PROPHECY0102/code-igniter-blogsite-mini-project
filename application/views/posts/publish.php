<div class="publish-container">
  <div class="publish-header-container">
    <h1 class="publish-heading">Write a post:</h1>
    <p class="publish-subheading">Both Title and Content Fields are required.</p>
  </div>
  <div class="form-container">
    <?php echo validation_errors(); ?>
    <?php echo form_open_multipart("posts/publish"); ?>
    <div class="form-title-container">
      <label for="title" class="form-title-label">Title:</label>
      <input type="text" name="title" class="form-text-input" placeholder="Enter a post title">
    </div>
    <div class="form-content-container">
      <label for="content" class="form-content-label">Content:</label>
      <textarea name="content" class="form-text-input content-textarea" placeholder="Enter a post content"></textarea>
    </div>
    <div class="form-image-container">
      <label for="post-image" class="form-image-label">Use a custom image for this post:</label>
      <input type="file" name="post-image" class="form-image-field">
    </div>
    <div class="form-publish-container">
      <input type="submit" value="Publish" class="btn-submit-post">
    </div>
    </form>
  </div>
</div>