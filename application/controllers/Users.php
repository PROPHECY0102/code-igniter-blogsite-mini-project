<?php

use function PHPSTORM_META\type;

/** 
 *
 * @property User_model $user_model
 * @property input $input
 * @property session $session
 *
 */
class Users extends CI_Controller
{
  protected $view_data;

  public function __construct()
  {
    parent::__construct();
    $this->load->library("session");
    $this->load->model("user_model");
    $this->load->library("auth");
    $this->load->library("alerts");
    $this->init_view_data();
  }

  private function init_view_data()
  {
    $this->view_data["auth"] = $this->auth->login_info;
    $this->view_data["notify"] = $this->session->flashdata("notify") ?? false;
    $this->view_data["notify_type"] = $this->session->flashdata("notify_type") ?? false;
    $this->view_data["notify_message"] = $this->session->flashdata("notify_message");
    $this->view_data["prev_route"] = $this->session->flashdata("prev_route");
  }

  public function login()
  {
    if ($this->auth->is_logged_in()) {
      $this->alerts->redirect_and_alert(array(
        "message" => "You have already logged in!"
      ));
    }
    $this->view_data["title"] = "Login";

    if ($this->input->method() === "get") {
      $this->view_data["login_response"] = array();
      $this->load->view("templates/header", $this->view_data);
      $this->load->view("users/login");
      $this->load->view("templates/footer");
      return null;
    }

    $req_body = $this->input->post();
    $request_check = $this->user_model->validate_login_request($req_body);
    if (!$request_check["request_valid"]) {
      $this->alerts->redirect_and_alert(array(
        "message" => $request_check["message"],
        "type" => "error",
        "destination" => "users/login"
      ));
    }

    $auth = $this->user_model->verify_user($req_body);

    if (!$auth["login_status"]) {
      $this->alerts->redirect_and_alert(array(
        "message" => $auth["message"],
        "type" => "error",
        "destination" => "users/login"
      ));
    }

    $user = $auth["user"];

    $session_data = array(
      "user_id" => $user["id"],
      "username" => $user["username"],
      "logged_in" => $auth["login_status"]
    );

    $this->session->set_userdata($session_data);
    $this->alerts->redirect_and_alert(array(
      "message" => $auth["message"],
    ));
  }

  public function register()
  {
    if ($this->auth->is_logged_in()) {
      $this->alerts->redirect_and_alert(array(
        "message" => "You have already logged in!"
      ));
    }
    $this->view_data["title"] = "Register";

    if ($this->input->method() === "get") {
      $this->view_data["register_response"] = array();
      $this->load->view("templates/header", $this->view_data);
      $this->load->view("users/register", $this->view_data);
      $this->load->view("templates/footer");
      return null;
    }

    $req_body = $this->input->post();
    $request_check = $this->user_model->validate_register_request($req_body);
    if (!$request_check["request_valid"]) {
      $this->alerts->redirect_and_alert(array(
        "message" => $request_check["message"],
        "type" => "error",
        "destination" => "users/register"
      ));
    }

    $credentials_check = $this->user_model->verify_register_credentials($req_body);

    if (!$credentials_check["register_status"]) {
      $this->alerts->redirect_and_alert(array(
        "message" => $credentials_check["message"],
        "type" => "error",
        "destination" => "users/register"
      ));
    }

    $user = $credentials_check["user"];

    $session_data = array(
      "user_id" => $user["id"],
      "username" => $user["username"],
      "logged_in" => $credentials_check["register_status"]
    );

    $this->session->set_userdata($session_data);
    $this->alerts->redirect_and_alert(array(
      "message" => $credentials_check["message"],
    ));
  }

  public function logout()
  {
    if (!$this->auth->is_logged_in()) {
      $this->alerts->redirect_and_alert(array(
        "message" => "You have not logged in!",
        "type" => "error",
        "destination" => "users/login"
      ));
    }

    $session_data = array(
      "user_id" => null,
      "username" => null,
      "logged_in" => false
    );

    $this->session->set_userdata($session_data);
    $this->alerts->redirect_and_alert(array(
      "message" => "You have been logged out!",
    ));
  }

  public function seed_admin()
  {
    $admin_username = "Admin";
    $admin_email = "Admin@example.com";
    $admin_password = 123456;

    $user_data = [
      "username" => $admin_username,
      "email" => $admin_email,
      "password" => $admin_password,
      "role" => "admin",
    ];

    $is_successful = $this->user_model->create_user($user_data);

    if ($is_successful) {
      $admin_user = $this->user_model->get_users($admin_username, "username");
      $this->load->view("users/seed_admin", $admin_user[0]);
      return null;
    }

    redirect("");
  }
}
