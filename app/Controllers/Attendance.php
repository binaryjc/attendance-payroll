<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Employee;
use App\Models\Attendance as Att_Model;
class Attendance extends BaseController
{ 
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->emp_model = new Employee;
        
        $this->att_model = new Att_Model();
        $this->data = ['session' => $this->session,'request'=>$this->request];
    }

    public function index()
    {
        $this->data['page_title']="Attendace";
        return view('pages/attendance', $this->data);

    }

    public function add()
    {
        if($this->request->getMethod() == 'post'){
            extract($this->request->getPost());
            $employee = $this->emp_model->where('code',$company_code)->first();
            if(isset($employee['id'])){
                $idata['employee_id'] = $employee['id'];
                if(isset($time_in)){
                    $idata['log_type'] = 1;
                    $lt ="Time In";
                }else{
                    $idata['log_type'] = 2;
                    $lt ="Time Out";
                }
                $check = $this->att_model->where('employee_id',$idata['employee_id'])->where('log_type',$idata['log_type'])->where('date(`created_at`)',date('Y-m-d'))->countAllResults();

                if($check == 1){
                    $idata['time_type'] = 'pm';
                    $save = $this->att_model->save($idata);
                    if($save){
                        $this->session->setFlashdata('success', "You have sucessfully added your {$lt} for (PM) Today.");
                        return redirect()->to('Attendance');
                    }else{
                        $this->session->setFlashdata('error', "An error occured.");
                    }
                }else if($check >= 2){
                    $this->session->setFlashdata('error', "You have already two {$lt} Record Today.");
                }else{
                    $idata['time_type'] = 'am';
                    $save = $this->att_model->save($idata);
                    if($save){
                        $this->session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                        return redirect()->to('Attendance');
                    }else{
                        $this->session->setFlashdata('error', "An error occured.");
                    }
                }
            }
        }
        $this->data['page_title']="Attendace";
        return view('pages/attendance', $this->data);
    }


    public function attendance_list(){
        $this->data['page_title']="Attendances";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->att_model->countAllResults();
        $this->data['attendances'] = $this->att_model
                                    ->select("`attendance`.*, `employees`.code, CONCAT(`employees`.last_name, ', ', `employees`.first_name, COALESCE(CONCAT(' ', `employees`.middle_name), '')) as `name`")
                                    ->join('employees','`attendance.employee_id = employees.id`','inner')
                                    ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['attendances'])? count($this->data['attendances']) : 0;
        $this->data['pager'] = $this->att_model->pager;
        return view('pages/attendances/list', $this->data);
    }
    public function employee_dtr($id){
        $this->data['page_title']="Attendances";
        //$this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        //$this->data['perPage'] =  10;
        //$builder = $this->$att_model->builder();

        $result = $this->att_model->getEmployeeDTR($id);

        echo '<pre>';
        print_r($result);die();
        echo json_encode($result);
/*$db = db_connect();
$sql = "SELECT `attendance`.*, `employees`.code, CONCAT(`employees`.last_name, ', ', `employees`.first_name, COALESCE(CONCAT(' ', `employees`.middle_name), '')) as `name` 
    FROM attendance 
    INNER JOIN employees on attendance.employee_id = employees.id
    WHERE employees.id = ?";
$db->query($sql, [3]);

        $this->data['attendances'] = $dtrs = $this->att_model
                                    ->select("`attendance`.*, `employees`.code, CONCAT(`employees`.last_name, ', ', `employees`.first_name, COALESCE(CONCAT(' ', `employees`.middle_name), '')) as `name`")
                                    ->join('employees','`attendance.employee_id = employees.id`','inner')
                                    ->where("employees.id = $id");
                                    //->paginate($this->data['perPage']);
*/
        echo '<pre>';
        print_r($dtrs);

        //$this->data['total'] =  count($dtrs);
        //$this->data['total_res'] = is_array($this->data['attendances'])? count($this->data['attendances']) : 0;
        //$this->data['pager'] = $this->att_model->pager;


        //return view('pages/attendances/dtr', $this->data);
    }

    public function attendance_delete($id=''){
        if(empty($id)){
                $this->session->setFlashdata('main_error',"Attendance Deletion failed due to unknown ID.");
                return redirect()->to('Main/attendances');
        }
        $delete = $this->att_model->where('id', $id)->delete();
        if($delete){
            $this->session->setFlashdata('main_success',"Attendance has been deleted successfully.");
        }else{
            $this->session->setFlashdata('main_error',"Attendance Deletion failed due to unknown ID.");
        }
        return redirect()->to('Main/attendances');
    }
}
