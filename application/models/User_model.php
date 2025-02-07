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
    $query = $this->db->where([$identifier_type => $unique_identifier]);
    $query = $this->db->get("users");
    return $query->result_array();
  }

  public function create_user($data = [])
  {
    $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

    return $this->db->insert("users", $data);
  }

  public function validate_login_request($login_data)
  {
    if (!isset($login_data["login_method"])) {
      return [
        "login_status" => false,
        "affected_field" => "login_method",
        "message" => "Login Method is Unspecified",
        "request_valid" => false
      ];
    }

    if (!isset($login_data["password"])) {
      return [
        "login_status" => false,
        "affected_field" => "password",
        "message" => "Password is Unspecified",
        "request_valid" => false
      ];
    }

    $login_method = $login_data["login_method"];
    if ($login_method !== "username" && $login_method !== "email") {
      return [
        "login_status" => false,
        "affected_field" => "login_method",
        "message" => "Login Method must be of either 'username' or 'email'",
        "request_valid" => false
      ];
    }

    if ($login_method === "username" && !isset($login_data["username"])) {
      return [
        "login_status" => false,
        "affected_field" => "username",
        "message" => "Username field is missing",
        "request_valid" => false
      ];
    }

    if ($login_method === "email" && !isset($login_data["email"])) {
      return [
        "login_status" => false,
        "affected_field" => "email",
        "message" => "Email field is missing",
        "request_valid" => false
      ];
    }

    return [
      "login_status" => false,
      "affected_field" => "",
      "message" => "User had not been verified",
      "request_valid" => true
    ];
  }

  public function verify_user($login_data)
  {
    $login_method = $login_data["login_method"]  ? "username" : "email";

    $query = $this->db->where([$login_method => $login_data[$login_method]])->get("users");
    $user = $query->row_array();

    if (empty($user)) {
      return [
        "login_status" => false,
        "reason" => $login_method,
        "message" => "User Not Found",
        "request_valid" => true
      ];
    }

    $password_match = password_verify($login_data["password"], $user["password"]);

    if (!$password_match) {
      return [
        "login_status" => false,
        "reason" => "password",
        "message" => "Password Does Not Match",
        "request_valid" => true
      ];
    }

    return [
      "user" => $user,
      "login_status" => true,
      "reason" => null,
      "message" => "Login Successful",
      "request_valid" => true
    ];
  }
}
