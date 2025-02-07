<?php

/**
 * @property Post_model $post_model
 * @property form_validation $form_validation
 * @property input $input
 */
class Posts extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library("session");
    $this->load->model("post_model");
  }

  public function index()
  {
    $data["title"] = "Latest Posts";
    $data['posts'] = $this->post_model->get_posts(false, "DESC");

    $this->load->view('templates/header', $data);
    $this->load->view('posts/index', $data);
    $this->load->view('templates/footer', $data);
  }

  public function view($slug = null)
  {
    $data["post"] = $this->post_model->get_posts($slug);

    if (empty($data['post'])) {
      show_404();
    }

    $data["title"] = $data["post"]["title"];

    $this->load->view('templates/header', $data);
    $this->load->view('posts/view', $data);
    $this->load->view('templates/footer');
  }

  public function publish()
  {
    $data["title"] = "Publish";

    $this->form_validation->set_rules("title", "Title", "required");
    $this->form_validation->set_rules("content", "Content", "required");

    if ($this->form_validation->run() === false) {
      $this->load->view('templates/header', $data);
      $this->load->view('posts/publish');
      $this->load->view('templates/footer');
      return null;
    }

    // TODO
    $reqBody = $this->input->post();
    $title = $reqBody["title"];
    $content = $reqBody["content"];

    $this->post_model->create_post($title, $content);
    redirect("posts");
  }

  public function delete($id)
  {
    $result = $this->post_model->delete_post($id);

    $response = [
      "result" => $result ? "Successfully deleted post ID of $id" : "Failed to delete post ID of $id",
      "deleted_successfully" => $result,
      "redirect" => base_url("/posts")
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  }

  public function seed($amount = 5)
  {
    $sample_text_str = "the,be,to,of,and,a,in,that,have,I,it,for,not,on,with,he,as,you,do,at,this,but,his,by,from,they,we,say,her,she,or,an,will,my,one,all,would,there,their,what,so,up,out,if,about,who,get,which,go,me,when,make,can,like,time,no,just,him,know,take,people,into,year,your,good,some,could,them,see,other,than,then,now,look,only,come,its,over,think,also,back,after,use,two,how,our,work,first,well,way,even,new,want,because,any,these,give,day,most,us,is,are,was,were,been,has,had,did,were,am,being,does,should,more,very,must,through,such,where,why,each,those,before,many,same,too,shall,here,under,off,always,never,might,without,between,another,however,since,while,within,few,several,during,against,both,around,every,each,own,toward,upon,among,less,far,ever,yet,though,once,soon,again,least,almost,rather,either,neither,instead,quite,perhaps,whether,although,already,indeed,therefore,thus,otherwise,besides,meanwhile,except,unless,nor,whom,whose,whichever,whatever,whenever,wherever,whoever,somebody,nobody,everybody,anybody,someone,anyone,everyone,everything,nothing,something,anything,somewhere,anywhere,nowhere,everywhere,myself,yourself,himself,herself,itself,ourselves,themselves,your,theirs,ours,mine,yours,his,hers,whose,which,that,this,these,those,own,old,new,young,little,long,big,small,great,high,low,early,late,fast,slow,next,last,hard,soft,dark,bright,hot,cold,warm,cool,dry,wet,strong,weak,happy,sad,angry,kind,mean,good,bad,better,best,worse,worst,beautiful,ugly,rich,poor,right,wrong,easy,difficult,simple,complex,important,necessary,possible,impossible,true,false,clear,unclear,certain,uncertain,sure,unsure,safe,dangerous,near,far,alone,together,left,right,up,down,inside,outside,above,below,front,back,north,south,east,west,morning,afternoon,evening,night,day,week,month,year,today,tomorrow,yesterday,soon,later,early,late,never,always,sometimes,often,rarely,usually,seldom,again,once,twice,thrice";

    $sample_text_array = explode(",", $sample_text_str);
    $titleLength = 10;
    $contentLength = 50;

    $seed_status = $this->genPosts($amount, $sample_text_array, $titleLength, $contentLength);
    return $this->load->view("posts/seed", $seed_status);
  }

  private function genPosts($amount = 5, $sample_text_array = [], $titleLength = 10, $contentLength = 50, $status_obj = ["failed_to_insert" => 0, "recurse" => false])
  {
    if ($status_obj["recurse"] === false) {
      $status_obj["original_amount"] = $amount;
    }
    if ($amount == 0) {
      $failed_to_insert = $status_obj["failed_to_insert"];
      return [
        "is_successful" => ($failed_to_insert == 0) ? "Successful" : "Failed",
        "amount_seeded" => $status_obj["original_amount"] - $failed_to_insert,
        "failed_to_insert" => $failed_to_insert
      ];
    }
    $this->load->model('post_model');
    $title = ucwords($this->genTitle($titleLength, $sample_text_array));
    $content = $this->genContent($contentLength, $sample_text_array);
    $insert_status = $this->post_model->create_post($title, $content);
    if ($insert_status == false) {
      $status_obj["failed_to_insert"]++;
    }
    $amount--;
    $status_obj["recurse"] = true;
    return $this->genPosts($amount, $sample_text_array, $titleLength, $contentLength, $status_obj);
  }

  private function genTitle($length = 10, $sample_text_array = [], $title = "")
  {
    if ($length == 0) {
      return $title;
    }
    $title = $title . " " . $sample_text_array[rand(0, count($sample_text_array) - 1)];
    return $this->genTitle($length - 1, $sample_text_array, $title);
  }

  private function genContent($length = 50, $sample_text_array = [], $content = "")
  {
    if ($length == 0) {
      return $content;
    }
    $content = $content . " " . $sample_text_array[rand(0, count($sample_text_array) - 1)];
    return $this->genContent($length - 1, $sample_text_array, $content);
  }
}
