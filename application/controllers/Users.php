<?php

/** 
 *
 * @property User_model $user_model
 *
 */
class Users extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("user_model");
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
      $admin_user = $this->user_model->get_users($admin_username);
      $this->load->view("users/seed_admin", $admin_user);
      return null;
    }

    print_r($is_successful);
    // redirect(base_url());
  }
}
