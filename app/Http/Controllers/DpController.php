<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DpController extends Controller
{
    //
    function __construct()
    {
        // $token = new token();
        // parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        // $this->load->model('dasar');
        // $this->load->model('m_absensi');
        // $this->load->model('auth');
        // $this->load->model('endpoint');
        // $this->load->model('payroll/dp_employee');
        // $this->load->model('payroll/kontrak_model');
        // $this->load->model('payroll/cuti_emp_model');
        // $tes = $token->cek_jwt();
        // if ($tes['status'] == 500) {
        //     $this->response([
        //         'msg' => "token tidak ada"
        //     ], 200);
        // } else {
        //     if ($tes['data_jwt']->is_login == false) {
        //         // echo "token";
        //         $this->response([
        //             'msg' => "token tidak ditemukan"
        //         ], 200);
        //     }
        // }
    }

    public function cek_saldo_dp(Request $request)
    {
        $stts_json = 200;
        $data = [];

        $nik = $request->input('nik');//ambil inputan nik
    
        $find_dp = DB::table('dp_employee')->where('nik','=',$nik)->get();
        if (count($find_dp) > 0) {
            $data_json = [];
            $dp_belum_finger = 0;
            $dp_sudah_finger = 0;
            $dp_sudah_terpakai = 0;
            $dp_expired = 0;
            $tgl_blm_finger = [];
            $tgl_sudah_finger = [];
            $tgl_sudah_terpakai = [];
            $tgl_expired = [];
            $today = strtotime(date('Y-m-d'));
            foreach ($find_dp as $row) {
                switch ($row->status) {
                    case 0:
                        if (strtotime($row->tgl_expired) < $today) {
                            $dp_expired++;
                            array_push($tgl_expired, $row->tgl);
                        }else{
                            $dp_belum_finger++;
                            array_push($tgl_blm_finger, $row->tgl);
                        }
                        break;
                    case 1:
                        if (strtotime($row->tgl_expired) < $today) {
                            $dp_expired++;
                            array_push($tgl_expired, $row->tgl);
                        }else{
                            $dp_sudah_finger++;
                            array_push($tgl_sudah_finger, $row->tgl);
                        }
                        break;
                    case 2:
                        $dp_sudah_terpakai++;
                        array_push($tgl_sudah_terpakai, $row->tgl);
                        break;
                }
            }
            $data['dt_cek_dp'] = array(
                'nama' => $data_token['data_jwt']->nama,
                'jumlah_dp_belum_aktif' => $dp_belum_finger,
                'tgl_dp_belum_aktif' => $tgl_blm_finger,
                'jumlah_dp_aktif' => $dp_sudah_finger,
                'tgl_dp_aktif' => $tgl_sudah_finger,
                'jumlah_dp_sudah_terpakai_or_expire' => $dp_sudah_terpakai,
                'tgl_dp_sudah_terpakai_or_expire' => $tgl_sudah_terpakai,
                // 'jumlah_dp_expired' => $dp_expired,
                // 'tgl_dp_expired' => $tgl_expired,
            );
        } else {
            $stts_json = 404;
            $data['msag'] = 'Data tidak ditemukan';
        }
        return $data;
        // $this->response(['msg' => $msg_json], $stts_json);
        // $this->input->post('nik')
        // return $this->generate_dp_post($this->input->post('nik'));
    }

    public function cek_saldo_cuti_get()
    {
        $stts_json = 200;
        $token = new token();
        $msg_create_cuti = '';
        $msg_update_cuti = '';
        $data_token = $token->cek_jwt();
        $nik = $data_token['data_jwt']->nik;

        //AMBIL LAST KONTRAK
        $kontrak_emp = kontrak_model::where('nik','=',$nik)->orderBy('tgl_dari','DESC')->first();
        // $data_kontrak_employee = $this->m_absensi->fetch_last_kontrak($nik);
        if (count((array)$kontrak_emp) > 0) {
            $d1 = new DateTime($kontrak_emp->tgl_dari);
            $d2 = new DateTime();
            $interval = $d1->diff($d2);
            $diff_bulan = $interval->m;
            //CEK EXIST CUTI_EMPLOYEE
            // $data_cuti = $this->m_absensi->fetch_cuti($nik, 1);
            $data_cuti = cuti_emp_model::where('nik','=',$nik)
                        ->where('status','=',1)
                        ->orderBy('id','DESC')
                        ->first();
            if (count((array)$data_cuti) > 0) {
                //update
                $data_cuti->jml_cuti = $diff_bulan;
                try{
                    if(!$data_cuti->save()){
                        $stts_json = 500;
                        $msg_update_cuti = "Gagal update cuti";
                    }else{
                        $msg_update_cuti = "Sukses update cuti";
                    }
                }catch(Exception $e){
                    $stts_json = 500;
                    $msg_update_cuti = "Error update data cuti : " . $e->getMessage();
                }
            } else {
                //create
                $cuti = new cuti_emp_model;
                $cuti->nik = $nik;
                $cuti->id_dept = $data_token['data_jwt']->id_dept;
                $cuti->no_kontrak = $kontrak_emp->no_kontrak;
                $cuti->tgl_mulai_cuti = date('Y-m-d', strtotime($kontrak_emp->tgl_dari . '+6 months'));
                $cuti->jml_cuti = $diff_bulan;
                $cuti->status = 1;
                $cuti->created_by = $nik;
                $cuti->created_date = date('Y-m-d H:i:s');
                if(!$cuti->save()){
                    $stts_json = 500;
                    $msg_update_cuti = "Gagal insert cuti";
                }
            }
            //AMBIL DATA CUTI TERUPDATE
            // $data_cuti_update = $this->m_absensi->fetch_last_cuti($nik, 1);
            $data_cuti_update = cuti_emp_model::where('nik','=',$nik)
                        ->where('status','=',1)
                        ->orderBy('id','DESC')
                        ->first();
            $msg = array(
                // 'kontrak_emp'=>$kontrak_emp,
                // 'data_cuti'=>$data_cuti
                'no_kontrak' => $data_cuti_update->no_kontrak,
                'total_cuti' => $data_cuti_update->jml_cuti,
                'cuti_terpakai' => $data_cuti_update->jml_cuti_terpakai,
                'saldo_cuti' => intval($data_cuti_update->jml_cuti - $data_cuti_update->jml_cuti_terpakai),
                'tgl_minimal_ambil' => $data_cuti_update->tgl_mulai_cuti,
                'msg_update_cuti'=>$msg_update_cuti,
                'msg_created_cuti'=>$msg_create_cuti,
            );
        } else {
            $stts_json = 404;
            $msg = array('pesan' => "Data Kontrak tidak dapat ditemukan ");
        }

        $this->response(['msg' => $msg], $stts_json);
        //echo $data_kontrak_employee->tgl_dari;

        //echo "d1 = ".$d1.", d2 = ".$d2." hasil = ". $diff_bulan;
    }




}
