<?php

class User_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_users($unique_identifier = false, $identifier_type = "id")
  {
    if ($unique_identifier === false) {
      $query = $this->db->get("users");
      return $query->result_array();
    }

    $available_columns = ["id", "username", "email"];
    $is_matching = false;
    foreach ($available_columns as $column) {
      if ($identifier_type === $column) {
        $is_matching = true;
      }
    }
    if ($is_matching === false) {
      throw new Exception("Unknown identifier cannot be filtered from the users table");
    }
    $query = $this->db->where([$identifier_type => $unique_identifier])->get("users");
  }

  public function create_user($data = [])
  {
    $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

    return $this->db->insert("users", $data);
  }
}
