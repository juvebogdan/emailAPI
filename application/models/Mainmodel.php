<?php
    // system/application/models/user.php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Mainmodel extends CI_Model {

            public function getinfo($user)
            {
                $this->db->where('username', $user);
                $query=$this->db->get('clients');
                return $query->result_array();
                //return 'cao';
            }
            public function updateclient($user,$num)
            {
                $sql = "update clients set iptvcredits=iptvcredits-$num where username='$user'";
                $this->db->query($sql);
            }
            public function statsinsert($user,$amount,$type,$client,$date,$pay)
            {
                $sql = "insert into stats values('$user',$amount,'$type','$client','$date',$pay)";
                $this->db->query($sql);
            }
            public function checkclient($username)
            {
                $this->db->where('username', $username);
                $query=$this->db->get('clients');
                return $query->num_rows();
            }
    }
?>