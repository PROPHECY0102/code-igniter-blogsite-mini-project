<?php
class Post_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_posts($slug = FALSE, $orderType = "ASC")
  {
    if ($slug === FALSE) {
      $query = $this->db->order_by("id", $orderType)->get('posts');
      return $query->result_array();
    }

    $query = $this->db->get_where('posts', ['slug' => $slug]);
    return $query->row_array();
  }

  public function create_post($title, $content)
  {
    $slug = strtolower(url_title($title, "-", TRUE));
    return $this->db->insert("posts", ["title" => $title, "slug" => $slug, "content" => $content]);
  }

  public function delete_post($id = null)
  {
    return $this->db->where(["id" => $id])->delete("posts");
  }
}
