<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('encryption');
        $this->encryption->initialize(cRYPT);
        $this->encryption->initialize(array('driver' => 'mycript'));
        $this->global['menu_list'] = array();
        $this->isLoggedIn();
        $t_roles = get_roles($this->session->userdata('userId'));
        if(!empty($t_roles))
         $this->global['menu_list']  = json_decode($t_roles[0]->content);


    }

    public function managerList(){
       $this->load->model('user_model');
        $this->load->library('pagination');
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        $records_count= sizeof( $this->user_model->managerListing(0,0,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content")));
        $returns = $this->paginationCompress ( "managerList/", $records_count,$this->input->get("shPageSize"));
        $data['userRecords'] = $this->user_model->managerListing($returns["page"],$returns["segment"],$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));
        $data['managers'] = $this->user_model->getUserRoles(0,1);
        $this->global['pageTitle'] = '관리';
        $this->loadViews("manager", $this->global, $data, NULL);
    }

    function userListing()
    {
        if(!in_array("111", $this->global['menu_list']))
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            $data['levels'] = $this->user_model->getUserRoles(0,-1);
            $this->load->library('pagination');
            $shPageSize = empty($this->input->get("shPageSize")) ? 10:$this->input->get("shPageSize");
            $count = $this->user_model->userListingCount($searchText,0,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));

			$returns = $this->paginationCompress ( "userListing/", $count, $shPageSize);

            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"],0,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));

            $this->global['pageTitle'] = '회원리스트';
            $data['rolss'] = $this->user_model->getUserRoles();
            $data["uc"] = $count;
            $data["pf"] = $returns["segment"];

            $this->loadViews("users", $this->global, $data, NULL);
        }
    }

    public function exitMember(){
      if(!in_array("111", $this->global['menu_list']) || !in_array("112", $this->global['menu_list']))
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            $data['levels'] = $this->user_model->getUserRoles(0,-1);
           $this->load->library('pagination');

            $count = $this->user_model->userListingCount($searchText,1,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));

            $returns = $this->paginationCompress ( "userListing/", $count, $this->input->get("shPageSize"));

            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"],1,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));
             $this->global['pageTitle'] = '탈퇴회원목록';
            $data["uc"] = $count;
            $data["pf"] = $returns["segment"];
            $this->loadViews("exitedusers", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if(!in_array("111", $this->global['menu_list']))
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();

            $this->global['pageTitle'] = 'CodeInsect : Add New User';

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    function addManger(){

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles(0);

            $this->global['pageTitle'] = 'CodeInsect : Add New User';

            $this->loadViews("addmanger", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * This function is used to add new user to the system
     */



    function addNewUser()
    {
        if(!in_array("111", $this->global['menu_list']))
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');

            if($this->form_validation->run() == FALSE)
            {
                $this->addManger();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $loginId  =$this->input->post("loginId");
                $mobile = $this->input->post("sMobNo1")."-".$this->input->post("sMobNo2")."-".$this->input->post("sMobNo3");
                $telephone = $this->input->post("sTelNo1")."-".$this->input->post("sTelNo2")."-".$this->input->post("sTelNo3");
                $nickname = $this->input->post("nickname");
                $birthday = $this->input->post("birthday");
                $postNum = $this->input->post("ZIP");
                $address = $this->input->post("ADDR_1");
                $ADDR_2 = $this->input->post("ADDR_2");
                $emailRecevice = $this->input->post("sEmailRcvYN");
                $sSmsRcvYN = $this->input->post("sSmsRcvYN");
                $userInfo = array(  'loginId'=>$loginId,
                                    'telephone'=>$telephone,
                                    'nickname'=>$nickname,
                                    'birthday'=>$birthday,
                                    'postNum'=>$postNum,
                                    'address'=>$address,
                                    "detail_address"=>$ADDR_2,
                                    "smsRecevice"=>$sSmsRcvYN,
                                    "emailRecevice"=>$emailRecevice,
                                    'email'=>$email,
                                    'password'=>$this->encryption->encrypt($password),
                                    'roleId'=>$roleId,
                                    'name'=> $name,
                                    'mobile'=>$mobile,
                                    'createdBy'=>$this->vendorId,
                                    'createdDtm'=>date('Y-m-d H:i:s'));
                if(empty($birthday))
                    unset($userInfo["birthday"]);
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);

                if($result > 0)
                {
                    $this->user_model->editUser(array("sase"=>"AH".str_pad($result, 4, '0', STR_PAD_LEFT)),$result);
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }

                redirect('addNew');
            }
        }
    }

    function addProcessmanger(){

        if(!in_array("111", $this->global['menu_list']))
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');

                $userInfo = array('email'=>$email, 'password'=>$this->encryption->encrypt($password), 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));

                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }

                redirect('managerList');
            }
        }
    }

    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        if(!in_array("111", $this->global['menu_list']))
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }

            if(!empty($this->input->get("isDeleted"))){

                $data['userInfo'] = $this->user_model->getUserInfo($userId,$this->input->get("isDeleted"));
            }

            else{

                $data['userInfo'] = $this->user_model->getUserInfo($userId);
            }

            $data['roles'] = $this->user_model->getUserRoles(-1,2);
            $this->load->model('base_model');
            $data["role_manage"] = $this->base_model->getSelect("tbl_role_management",array(array("record"=>"userId","value"=>$userId)));
            $this->global['pageTitle'] = 'CodeInsect : Edit User';
            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if(!in_array("111", $this->global['menu_list']))
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $userId = $this->input->post('userId');

            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');

            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');
                $zip = $this->input->post('zip');
                $addr_1 = $this->input->post('addr_1');
                $telephone = $this->input->post('telephone');
                $details = $this->input->post('details');
                $loginId = $this->input->post('loginId');
                $nickname = $this->input->post('nickname');
                $isDeleted = $this->input->post("isDeleted");

                $birthday = $this->input->post('birthday');
                $log_num = $this->input->post('log_num');
                $log_date = date("Y-m-d");
                $createdDtm = $this->input->post("createdDtm");
                $emailRecevice = $this->input->post('emailRecevice');
                $smsRecevice = $this->input->post("smsRecevice");
                $complete_orders = empty($this->input->post("complete_orders")) ? 0: $this->input->post("complete_orders");
                $userInfo = array();
                if(empty($password))
                {
                    $userInfo = array(  'email'=>$email,
                                        'roleId'=>$roleId,
                                        'name'=>$name,
                                        'mobile'=>$mobile,
                                        'updatedBy'=>$this->vendorId,
                                        'updatedDtm'=>date('Y-m-d H:i:s'),
                                        'postNum'=>$zip,
                                        'address'=>$addr_1,'
                                         detail_address'=>$details,
                                        'telephone'=>$telephone,
                                        'nickname'=>$nickname,
                                        'loginId'=>$loginId,
                                        'isDeleted'=>$isDeleted,
                                        'birthday'=>$birthday,
                                        'log_num'=>$log_num,
                                        'log_date'=>$log_date,
                                        'createdDtm'=>$createdDtm,
                                        'smsRecevice'=>$smsRecevice,
                                        'emailRecevice'=>$emailRecevice,
                                        'complete_orders'=>$complete_orders);
                }
                else
                {
                    $userInfo = array(  'email'=>$email,
                                        'password'=>$this->encryption->encrypt($password),
                                        'roleId'=>$roleId,
                                        'name'=>ucwords($name), 'mobile'=>$mobile,
                                        'updatedBy'=>$this->vendorId,
                                        'updatedDtm'=>date('Y-m-d H:i:s'),
                                        'postNum'=>$zip,'address'=>$addr_1,
                                        'detail_address'=>$details,'telephone'=>$telephone,
                                        'nickname'=>$nickname,
                                        'loginId'=>$loginId,
                                        'isDeleted'=>$isDeleted);
                                }

                if(empty($createdDtm))
                    unset($userInfo["createdDtm"]);

                $result = $this->user_model->editUser($userInfo, $userId);

                if($result == true)
                {
                    if(!empty($this->input->post("settings"))){
                        $settings = json_encode($this->input->post("settings"));
                        $this->load->model('base_model');
                        $old_setting = $this->base_model->getSelect("tbl_role_management",array(array("record"=>"userId","value"=>$userId)));
                        if(empty($old_setting))
                            $this->base_model->insertArrayData("tbl_role_management",array("content"=>$settings,"userId"=>$userId));
                        else
                            $this->base_model->updateDataById($userId,array("content"=>$settings),"tbl_role_management","userId");
                    }
                    $this->session->set_flashdata('success', 'User updated successfully');


                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }

                redirect('userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if(!in_array("111", $this->global['menu_list']))
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            if(!empty($this->input->post("sure")) && $this->input->post("sure")==1){
                $this->user_model->deleteUserForever($userId);
                echo(json_encode(array('status'=>TRUE)));
            }
            else{
                $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                $result = $this->user_model->deleteUser($userId, $userInfo);
                if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
                else { echo(json_encode(array('status'=>FALSE))); }
            }
        }
    }

    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'CodeInsect : Change Password';

        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }


    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');

        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);

            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>$this->encryption->encrypt($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));

                $result = $this->user_model->changePassword($this->vendorId, $usersData);

                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }

                redirect('loadChangePass');
            }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';

        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>
