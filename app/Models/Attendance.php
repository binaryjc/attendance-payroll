<?php

namespace App\Models;

use CodeIgniter\Model;

class Attendance extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'attendance';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['employee_id','log_type','time_type'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];



    function getEmployeeDTR($id){
        $db = db_connect();
        $builder = $this->db->table('attendance');

        $builder->where('employee_id', $id);
        $builder->groupBy('MONTH(created_at), DAY(created_at) ,YEAR(created_at)');

        $raw_results = $builder->get()->getResultArray();

        $final_array = array();
        foreach ($raw_results as $row) {
            $temp = array();
            $temp = $row;
            $new_date = date("Y-m-d",strtotime($row['created_at']));
            $temp['time']['in_am'] = $this->get_attendance_entry_type($id,$new_date,'am',1);
            $temp['time']['out_am'] = $this->get_attendance_entry_type($id,$new_date,'am',2);
            $temp['time']['in_pm'] = $this->get_attendance_entry_type($id,$new_date,'pm',1);
            $temp['time']['out_pm'] = $this->get_attendance_entry_type($id,$new_date,'pm',2);
            $final_array[] = $temp;
        }

        return $final_array;
    }

    function get_attendance_entry_type($id,$date,$time_type,$log_type){
        $db = db_connect();
        $builder = $this->db->table('attendance');
        $builder->select('created_at');
        $builder->where('employee_id', $id);
        $builder->where('log_type', $log_type);
        $builder->where('time_type', $time_type);
        $builder->like('created_at', $date, 'after'); 

        $res = $builder->get()->getRowArray();

        if(isset($res['created_at'])){
           return $res['created_at']; 
       }else{
            return null;
       }

        
    }

}
