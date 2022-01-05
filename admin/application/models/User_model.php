<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '',$isDeleted=0,$st=null,$et=null,$level=null,$item=null,$content=null)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        $this->db->where('BaseTbl.isDeleted', $isDeleted);
        $this->db->where('Role.type !=', 0);
        if($st !=null) $this->db->where("BaseTbl.createdDtm >=",$st);
        if($et !=null) $this->db->where("BaseTbl.createdDtm <=",$et);
        if($level !=null) $this->db->where("Role.roleId",$level);
        if($content !=null) {
            $content = trim($content);
            switch ($item) {
                case "B":
                    # code...
                    $this->db->like("BaseTbl.name",$content,'both');
                    break;
                case "A":
                    # code...
                    $this->db->like("BaseTbl.loginId",$content,'both');
                    break;
                case "D":
                    # code...
                    $this->db->like("BaseTbl.nickname",$content,"both");
                    break;
                case "E":
                    # code...
                    $this->db->like("BaseTbl.sase",$content,'both');
                    break;
                case "F":
                    # code...
                    $this->db->like("BaseTbl.email",$content,'both');
                    break;

                default:
                    # code...
                    break;
            }
        }
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText = '', $page, $segment,$isDeleted=0,$st=null,$et=null,$level=null,$item=null,$content=null)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role,BaseTbl.loginId,BaseTbl.nickname,BaseTbl.deposit,BaseTbl.point,BaseTbl.createdDtm,BaseTbl.loginId,BaseTbl.log_date,BaseTbl.log_num,BaseTbl.birthday,BaseTbl.emailRecevice,BaseTbl.smsRecevice,BaseTbl.complete_orders');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        $this->db->join('delivery as Delivery', 'Delivery.userId = BaseTbl.userId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', $isDeleted);
        $this->db->where('Role.type !=', 0);
        if($st !=null) $this->db->where("BaseTbl.createdDtm >=",$st);
        if($et !=null) $this->db->where("BaseTbl.createdDtm <=",$et);
        if($level !=null) $this->db->where("Role.roleId",$level);
        if($content !=null) {
            $content = trim($content);
            switch ($item) {
                case "B":
                    # code...
                    $this->db->like("BaseTbl.name",$content,'both');
                    break;
                case "A":
                    # code...
                    $this->db->like("BaseTbl.loginId",$content,'both');
                    break;
                case "D":
                    # code...
                    $this->db->like("BaseTbl.nickname",$content,"both");
                    break;
                case "E":
                    # code...
                    $this->db->like("BaseTbl.sase",$content,'both');
                    break;
                case "F":
                    # code...
                    $this->db->like("BaseTbl.email",$content,'both');
                    break;

                default:
                    # code...
                    break;
            }
        }
        $this->db->limit($page, $segment);
        $this->db->group_by("BaseTbl.userId");
        $this->db->order_by("BaseTbl.createdDtm","DESC");
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function managerListing($limit1=0,$limit2=0,$st=null,$et=null,$level=null,$item=null,$content=null){
        $this->db->select('BaseTbl.*, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('Role.type =', 0);
        if($st !=null) $this->db->where("BaseTbl.createdDtm >=",$st);
        if($et !=null) $this->db->where("BaseTbl.createdDtm <=",$st);
        if($level !=null) $this->db->where("Role.roleId",$level);
        if($content !=null) $this->db->where("BaseTbl.".$item,$content);
        if($limit1 ==0 && $limit2==0){}
        else $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles($role=1,$type=1)
    {
        $this->db->select('roleId, role,level');
        $this->db->from('tbl_roles');
        if($type==1) $this->db->where('type', $role);
        else {$this->db->where('type >', $role);}
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId,$isDeleted=0)
    {
        $this->db->select(' tbl_users.emailRecevice,
                            tbl_users.smsRecevice,
                            tbl_users.log_num,
                            tbl_users.birthday,
                            tbl_users.createdDtm,
                            tbl_users.log_date,
                            tbl_users.log_num,
                            tbl_users.userId,
                            tbl_users.name,
                            tbl_users.email,
                            tbl_users.mobile,
                            tbl_users.roleId,
                            tbl_users.point,
                            tbl_users.deposit,
                            tbl_users.postNum,
                            tbl_users.address,
                            tbl_users.detail_address,
                            tbl_users.telephone,
                            tbl_users.loginId,
                            tbl_users.nickname,
                            tbl_users.session_id,
                            tbl_users.complete_orders,
                            Role.type,
                            Role.role,
                            Role.level');
        $this->db->from('tbl_users');
        $this->db->join('tbl_roles as Role', 'Role.roleId = tbl_users.roleId','left');
        $this->db->where('tbl_users.isDeleted', $isDeleted);
		$this->db->where('tbl_users.roleId !=', 1);
        $this->db->where('tbl_users.userId', $userId);
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        return TRUE;
    }



    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');

        $user = $query->result();

        if(!empty($user)){
            if($this->encryption->decrypt($user[0]->password) ==$oldPassword)
                return $user;
             else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);

        return $this->db->affected_rows();
    }

    public function deleteUserForever($id){
        $this->db->where('userId', $id);
        $this->db->delete('tbl_users');
    }
}
