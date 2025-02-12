<?php

class Pages extends CI_Controller
{
  protected $view_data;

  public function __construct()
  {
    parent::__construct();
    $this->load->library("session");
    $this->load->model("user_model");
    $this->load->library("auth");
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

  public function view($page = 'home')
  {
    if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
      show_404();
    }

    $this->view_data["auth"] = $this->auth->login_info;

    $this->view_data["title"] = "Home";
    $this->load->view('templates/header', $this->view_data);
    $this->load->view("pages/$page", $this->view_data);
    $this->load->view('templates/footer', $this->view_data);
  }
}
