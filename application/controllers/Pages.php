<?php

/**
 * @property session $session
 * @property User_model $user_model
 */
class Pages extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library("session");
    $this->load->model("user_model");
  }
  public function view($page = 'home')
  {
    if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
      show_404();
    }

    $logged_in = false;
    $session_available = $this->session->has_userdata("logged_in");
    if ($session_available) {
      $logged_in = $this->session->userdata("logged_in");
    }

    if ($logged_in) {
      $user_id = $this->session->userdata("user_id");
      $result = $this->user_model->get_users($user_id, "id");
      $user = $result[0];
      $data = array(
        "user" => $user,
        "logged_in" => $logged_in
      );
    } else {
      $data["logged_in"] = $logged_in;
    }

    $data["title"] = "Home";
    $this->load->view('templates/header', $data);
    $this->load->view("pages/$page", $data);
    $this->load->view('templates/footer', $data);
  }
}
