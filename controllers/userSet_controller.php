<?php
    require_once('models/memberModel.class.php');
    class UserSetController
    {
        public function index_userSet($param = NULL)
        {
            include('views/userSet/index_userSet.php');
        }
        public function upload_image($param = NULL)
        {
            $check = Member::upload_image($param['imagebase64'],$_SESSION['member']['id_member'],$_SESSION['member']['username']);
            header('location:index.php?controller=userSet&action=index_userSet');
        }
       
    }
?>