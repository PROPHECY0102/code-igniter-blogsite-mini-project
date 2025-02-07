<?php

/** 
 *
 * @property User_model $user_model
 * @property input $input
 * @property session $session
 *
 */
class Users extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library("session");
    $this->load->model("user_model");
  }

  public function login()
  {
    $data["title"] = "Login";

    if ($this->input->method() === "get") {
      $data["login_response"] = array();
      $this->load->view("templates/header", $data);
      $this->load->view("users/login");
      $this->load->view("templates/footer");
      return null;
    }

    $req_body = $this->input->post();
    $request_check = $this->user_model->validate_login_request($req_body);
    if (!$request_check["request_valid"]) {
      $data["login_response"] = $request_check;
      $this->load->view("templates/header", $data);
      $this->load->view("users/login", $data);
      $this->load->view("templates/footer");
      return null;
    }

    $auth = $this->user_model->verify_user($req_body);

    if (!$auth["login_status"]) {
      $data["login_response"] = $auth;
      $this->load->view("templates/header", $data);
      $this->load->view("users/login", $data);
      $this->load->view("templates/footer");
      return null;
    }

    $user = $auth["user"];

    $session_data = array(
      "user_id" => $user["id"],
      "username" => $user["username"],
      "logged_in" => $auth["login_status"]
    );

    $this->session->set_userdata($session_data);
    redirect('');
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

    print_r($is_successful);
    // redirect(base_url());
  }
}
