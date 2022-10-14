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

        $combined_array = array();
        
        //FIXED TIME SCHEME 8-12 1-5    
        foreach ($result as $row) {
            $temp = array();
            $temp = $row;

            $late = 0;
            $undertime = 0;
            $overtime = 0;

            //SOLVING FOR LATE
            foreach ($row['time'] as $time => $value) {

                if($value != null || $value != ''){
                    //late morning only
                    if($time == 'in_am'){
                        $created_at = $value;
                        $dt = new \DateTime($created_at);
                        $date = $dt->format('Y-m-d');
                        $time = $dt->format('H:i:s'); //time in database

                        $schemedatetime = new \DateTime($date.' 08:00:00 AM');
                        $scheme_time = $schemedatetime->format('H:i:s');

                        //check if time is late, otherwise dont count late minutes
                        if($dt > $schemedatetime){
                            $diff = $schemedatetime->diff($dt);
                            $total_minutes = ($diff->days * 24 * 60); 
                            $total_minutes += ($diff->h * 60); 
                            $total_minutes += $diff->i; 

                            $late += $total_minutes;
                        }
                    }//check am

                    //late pm only
                    if($time == 'in_pm'){
                        $created_at = $value;
                        $dt = new \DateTime($created_at);
                        $date = $dt->format('Y-m-d');
                        $time = $dt->format('H:i:s'); //time in database

                        $schemedatetime = new \DateTime($date.' 13:00:00');
                        $scheme_time = $schemedatetime->format('H:i:s');

                        //check if time is late, otherwise dont count late minutes
                        if($dt > $schemedatetime){
                            $diff = $schemedatetime->diff($dt);
                            $total_minutes = ($diff->days * 24 * 60); 
                            $total_minutes += ($diff->h * 60); 
                            $total_minutes += $diff->i; 

                            $late += $total_minutes;
                        }
                    }//check pm
                }

            }

            //SOLVING FOR AM UNDERTIME - if logout value exists
            if($row['time']['out_am'] !=null || $row['time']['out_am'] != ''){

                $out_am = new \DateTime($row['time']['out_am']);
                    $date = $out_am->format('Y-m-d');
                    $schemedatetime_outam = new \DateTime($date.' 12:00:00');
                
                //calculate if less then expected logout time
                if($out_am < $schemedatetime_outam){
                    $am_kulangtime = $this->getdiffminutes($out_am,$schemedatetime_outam); // 12pm minus the employee logout time
                    $undertime += $am_kulangtime;
                }
            }else{
                //no logout value exists
                $undertime += 240; //plus 4hours undertime
            }

            //SOLVING FOR PM UNDERTIME - if logout value exists
            if($row['time']['out_pm'] !=null || $row['time']['out_pm'] != ''){

                $out_pm = new \DateTime($row['time']['out_pm']);
                    $date = $out_pm->format('Y-m-d');
                    $schemedatetime_outpm = new \DateTime($date.' 17:00:00');
                
                //calculate if less then expected logout time
                if($out_pm < $schemedatetime_outpm){
                    $pm_kulangtime = $this->getdiffminutes($out_pm,$schemedatetime_outpm); // 12pm minus the employee logout time
                    $undertime += $pm_kulangtime;
                }
            }else{
                //no logout value exists
                $undertime += 240; //plus 4hours undertime
            }

            //SOLVING FOR OVERTIME
            if($row['time']['out_pm'] !=null || $row['time']['out_pm'] != ''){
                //excess time lang sa hapon

                $out_pm = new \DateTime($row['time']['out_pm']);
                    $date = $out_pm->format('Y-m-d');
                    $schemedatetime_outpm = new \DateTime($date.' 17:00:00');
                
                //calculate if logout time exceeds expected scheme time
                if($out_pm > $schemedatetime_outpm){
                    $pm_overtime = $this->getdiffminutes($schemedatetime_outpm,$out_pm); // 12pm minus the employee logout time
                    $overtime += $pm_overtime;
                }

            }


            $temp['late'] = $late;
            $temp['undertime'] = $undertime;
            $temp['overtime'] = $overtime;

            $combined_array[] = $temp;
        }
        //get timeframe
        //solve for late
        //solve for undertime

        print_r($combined_array);

        die();
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


        //$this->data['total'] =  count($dtrs);
        //$this->data['total_res'] = is_array($this->data['attendances'])? count($this->data['attendances']) : 0;
        //$this->data['pager'] = $this->att_model->pager;
        //return view('pages/attendances/dtr', $this->data);
    }

    function getdiffminutes($dtime1,$dtime2){
        $output = 0;
        $diff = $dtime2->diff($dtime1);
        $total_minutes = ($diff->days * 24 * 60); 
        $total_minutes += ($diff->h * 60); 
        $total_minutes += $diff->i; 

        $output += $total_minutes;
        return $output;        
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
