<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth
{
  protected $CI;
  public $login_info;

  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->library("session");
    $this->CI->load->model("user_model");

    $session_available = $this->CI->session->has_userdata("logged_in");
    if ($session_available) {
      $this->login_info["logged_in"] = $this->CI->session->userdata("logged_in");
    } else {
      $this->login_info["logged_in"] = false;
      $this->login_info["user"] = null;
    }

    if ($this->login_info["logged_in"]) {
      $user_id = $this->CI->session->userdata("user_id");
      $result = $this->CI->user_model->get_users($user_id, "id");

      if (empty($result)) {
        $this->login_info["logged_in"] = false;
        $this->login_info["user"] = null;
      }

      $user = $result[0];
      $this->login_info["user"] = $user;
    }
  }

  public function get_user_id()
  {
    $curr_user = $this->login_info["user"];
    if ($curr_user == null) {
      return null;
    }
    return $curr_user["id"];
  }

  public function is_logged_in()
  {
    return $this->login_info["logged_in"] ? true : false;
  }

  public function is_role_admin()
  {
    $user = $this->login_info["user"];
    if ($user == null) {
      return false;
    }

    return $user["role"] === "admin" ? true : false;
  }

  public function no_auth_redirect($params)
  {
    if (!$this->is_logged_in()) {
      $no_auth = array(
        "notify" => true,
        "notify_message" => "You must be signed in to {$params['message']}!",
        "notify_type" => $params["type"] ?? "error",
        "prev_route" => $params["prev_route"] ?? uri_string()
      );
      $this->CI->session->set_flashdata($no_auth);
      redirect($params["destination"] ?? "users/login");
    }
  }
}
