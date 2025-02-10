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
    $user_data = array(
      "username" => $data["username"],
      "email" => $data["email"],
      "password" => password_hash($data["password"], PASSWORD_BCRYPT),
      "role" => $data["role"] ?? "user",
      "bio" => $data["bio"] ?? ""
    );

    return $this->db->insert("users", $user_data);
  }

  public function validate_login_request($login_data)
  {
    if (empty($login_data["login_method"])) {
      return [
        "login_status" => false,
        "affected_field" => "login_method",
        "message" => "Login Method is Unspecified",
        "request_valid" => false
      ];
    }

    if (empty($login_data["password"])) {
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

    if ($login_method === "username" && empty($login_data["username"])) {
      return [
        "login_status" => false,
        "affected_field" => "username",
        "message" => "Username field is missing",
        "request_valid" => false
      ];
    }

    if ($login_method === "email" && empty($login_data["email"])) {
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

  public function validate_register_request($register_data)
  {
    $required_fields = array("username", "email", "password", "confirm_password");
    $missing_fields_check = array(
      "fields_incomplete" => false,
      "fields" => array()
    );

    foreach ($required_fields as $field) {
      if (empty($register_data[$field])) {
        $missing_fields_check["fields_incomplete"] = true;
        array_push($missing_fields_check["fields"], $field);
      }
    }

    if ($missing_fields_check["fields_incomplete"]) {
      $fields_missing = implode(",", $missing_fields_check["fields"]);
      return array(
        "register_status" => false,
        "affected_field" => $fields_missing,
        "message" => "Required Fields for registering to blogsite are missing",
        "request_valid" => false
      );
    }

    $invalid_email = preg_match("/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/", $register_data["email"]) === 1 ? false : true;

    if ($invalid_email) {
      return array(
        "register_status" => false,
        "affected_field" => "email",
        "message" => "Email field is not a valid email",
        "request_valid" => false
      );
    }

    if ($register_data["password"] !== $register_data["confirm_password"]) {
      return array(
        "register_status" => false,
        "affected_field" => "password",
        "message" => "Password does not match Confirm Password",
        "request_valid" => false
      );
    }

    return array(
      "register_status" => false,
      "affected_field" => "",
      "message" => "User account is pending verification",
      "request_valid" => true
    );
  }

  public function verify_register_credentials($register_data)
  {
    $username = $this->db->escape($register_data["username"]);
    $email = $this->db->escape($register_data["email"]);
    $sql = "SELECT * FROM `users` WHERE username=" . $username . "OR email=" . $email;
    $query = $this->db->query($sql);
    $user_exist = $query->result_array();

    if (!empty($user_exist)) {
      $user = $user_exist[0];
      if ($user["username"] === $username) {
        return array(
          "register_status" => false,
          "reason" => "username",
          "message" => "$username has been taken!",
          "request_valid" => true
        );
      }
      if ($user["email"] === $email) {
        return array(
          "register_status" => false,
          "reason" => "email",
          "message" => "$email has been taken!",
          "request_valid" => true
        );
      }
    }

    $register_status = $this->create_user($register_data);

    if ($register_status === false) {
      return array(
        "register_status" => $register_status,
        "reason" => "Database",
        "request_data" => json_encode($register_data),
        "message" => "Something went wrong unable to register this user",
        "request_valid" => true
      );
    }

    $users = $this->get_users($register_data["username"], "username");
    $current_user = $users[0];

    return array(
      "user" => $current_user,
      "register_status" => $register_status,
      "reason" => "",
      "message" => "{$current_user["username"]} has been successfully created!",
      "request_valid" => true
    );
  }

  public function verify_user($login_data)
  {
    $login_method = $login_data["login_method"];

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
      "reason" => "",
      "message" => "Login Successful",
      "request_valid" => true
    ];
  }
}
