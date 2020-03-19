<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class AdminModel extends CI_Model {

    public function insertQuery($tbl,$data){       
        $this->db->insert($tbl,$data);
        return $this->db->insert_id();
    }


    public function fetchQuery($select,$tbl,$where=NULL,$orderName=NULL,$ascDsc=NULL,$joinTbl=NULL,$joinId=NULL,$joinLR=NULL,$groupBy=NULL,$sLimit=NULL,$eLimit=NULL){
        $this->db->select($select);
        $this->db->from($tbl);
        if(!empty($where)){
            $this->db->where($where);
        }   
        if(!empty($groupBy)){
            $this->db->group_by($groupBy);
        }
        if(!empty($orderName)){
            $this->db->order_by($orderName,$ascDsc);
        }   
        if($eLimit>0){
            $this->db->limit($eLimit,$sLimit);
        }
        if(!empty($joinTbl)){
            $this->db->join($joinTbl, $joinId,$joinLR);
        }
        $query = $this->db->get();
        //echo $this->db->last_query(); die();
        return $query->result_array();
    }

    public function countQuery($tbl,$where=NULL,$joinTbl=NULL,$joinId=NULL,$joinLR=NULL){
        $this->db->select('count(*) as total');
        $this->db->from($tbl);
        if(!empty($where)){
            $this->db->where($where);
        }        
        if(!empty($joinTbl)){
            $this->db->join($joinTbl, $joinId,$joinLR);
        }
        $query = $this->db->get();
        //echo $this->db->last_query(); die();
        $cnt = $query->row_array();
        return $cnt['total'];
    }

    public function deleteQuery($tbl,$where=''){       
        if(!empty($where)){
            $this->db->where($where);
        }       
        $this->db->delete($tbl);
        if($this->db->affected_rows()>0)
            return 1;
        else
            return 0;
    }

    public function updateQuery($tbl,$data,$where=''){       
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->update($tbl,$data);
        return 1;
    }

    public function customFetchQuery($select,$tbl,$where='',$order='',$limit=''){
        $qry = "SELECT $select FROM $tbl $where $order $limit";

        $query = $this->CI->db->query($qry);
        //echo $this->CI->db->last_query(); die();
        return $query->result_array();        
    }



} // class APIModel end


?>