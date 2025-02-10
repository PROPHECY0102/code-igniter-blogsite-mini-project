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

  public function get_paginated_posts($limit, $offset, $orderType = "ASC")
  {
    $orderType = $orderType === "ASC" ? "ASC" : "DESC";
    if (is_numeric($limit) || is_numeric($offset)) {
      $sql = "SELECT * FROM `posts` ORDER BY id $orderType LIMIT $limit OFFSET $offset";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    return array();
  }

  public function get_total_posts()
  {
    $sql = "SELECT COUNT(*) AS `total_posts` FROM `posts`";
    $query = $this->db->query($sql);
    $query_result = $query->row_array();
    return $query_result["total_posts"];
  }

  public function get_post_by_id($id)
  {
    $sql = "SELECT * FROM `posts` WHERE id=" . $this->db->escape($id);
    $query = $this->db->query($sql);
    return $query->row_array();
  }

  public function create_post($title, $content)
  {
    $slug = strtolower(url_title($title, "-", TRUE));
    return $this->db->insert("posts", ["title" => $title, "slug" => $slug, "content" => $content]);
  }

  public function update_post($id, $title, $content)
  {
    $slug = strtolower(url_title($title, "-", TRUE));
    $sql = "UPDATE `posts` SET title={$this->db->escape($title)}, slug={$this->db->escape($slug)}, content={$this->db->escape($content)} WHERE id={$this->db->escape($id)}";
    return $this->db->query($sql);
  }

  public function delete_post($id = null)
  {
    return $this->db->where(["id" => $id])->delete("posts");
  }
}
