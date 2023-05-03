<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Endpoint;

class AbsenController extends Controller
{
    //

    function __construct()
    {
        // $token = new token();
        // parent::__construct();
        // date_default_timezone_set('Asia/Jakarta');

        // $this->load->model('dasar');
        // // $this->load->model('m_absensi');
        // $this->load->model('auth');
        // $this->load->model('m_dp');
        // $this->load->model('m_pengajuan');
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
       // $this->load->model('endpoint');
    }
    public function index_post()
    {
        $stts_json = 200;
        $data = [];
        $msg = '';
        // $data['msg'] = '';
        $token = new token();
        // $notif = new notif();
        $data_token = $token->cek_jwt();

        $nik = $data_token['data_jwt']->nik;
        $keterangan = $this->input->post('keterangan');
        $jenis_cuti = $this->input->post('jenis_cuti');
        $tanggal = $this->input->post('tgl');
        //VALIDASI CUTI
        if ($jenis_cuti == 'Cuti') {
            $do_validasi_cuti = $this->validasi_cuti($nik);
            $stts_json = $do_validasi_cuti['status'];
            //$data['msg'] = $do_validasi_cuti['msg'];
            $msg = $do_validasi_cuti['msg'];
        }
        if ($stts_json == 200) {
            $do_create_request = $this->create_cuti($jenis_cuti, $keterangan, $tanggal);
            if ($do_create_request['status'] == 200) {
                $approval_dp = $this->m_pengajuan->find_approval($nik, 'DP', 1); //STATUS APPROVAL DP == CUTI
                //BUAT NOTIF
                $arr_notif = array(
                    'nik_from' => $nik,
                    'nik_to' => $approval_dp->nik,
                    'jenis' => $jenis_cuti,
                    'id_transaksi' => $do_create_request['id_header'],
                    'tgl' => date('Y-m-d'),
                    'status' => 0,
                    'msg' => "PENGAJUAN " . $jenis_cuti . " ATAS NAMA " . $data_token['data_jwt']->nama,
                    'created_by' => $data_token['data_jwt']->nik,
                    'created_date' => date('Y-m-d H:i:s')
                );
                try {
                    $this->dasar->insert_table('notif', $arr_notif, 'PAYROLL');
                    $data['msg-notif'] = 'Notif success created';
                } catch (Exception $e) {
                    $stts_json = 500;
                    $data['msg-notif'] = 'Notif failed created = ' . $e->getMessage();
                }
                $msg = array(
                    'create_request' => $do_create_request['msg'],
                    'notif' => $data['msg-notif']
                );
            } else {
                $stts_json = $do_create_request['status'];
                $msg = $do_create_request['msg'];
            }
        }
        $this->response(['msg' => $msg], $stts_json);
    }
    function validasi_cuti($nik)
    {
        $data = [];
        $data['status'] = 200;
        $data['msg'] = 'Ok';
        $data_cuti = $this->m_pengajuan->fetch_cuti($nik);
        if (count((array)$data_cuti) > 0) {
            if (date('Y-m-d') < $data_cuti->tgl_mulai_cuti) {
                $data['status'] = 500;
                $data['msg'] = 'Cuti dapat diambil pada tanggal ' . $data_cuti->tgl_mulai_cuti;
            }
        } else {
            $data['status'] = 404;
            $data['msg'] = 'Harap melakukan cek saldo cuti';
        }
        return $data;
    }
    function create_cuti($jenis, $keterangan, $tanggal)
    {
        $data = [];
        $data['status'] = 200;
        $data['msg'] = '';
        $token = new token();
        $data_token = $token->cek_jwt();
        $nik = $data_token['data_jwt']->nik;

        $jenis_approve = $this->m_pengajuan->find_jumlah_approve($nik, 'DP'); //STATUS CUTI == DP
        $status_request = 0;
        if ($jenis_approve->jumlah_approve == 1) {
            $status_request = 1;
        }
        $arr_insert = array(
            'nik' => $nik,
            'id_dept' => $data_token['data_jwt']->id_dept,
            //'id_dp' => $dp_dapat_digunakan->id,
            'jenis' => $jenis,
            'tgl_request' => date('Y-m-d'),
            'status' => $status_request,
            'keterangan' => $keterangan,
            'created_by' => $data_token['data_jwt']->nik,
            'created_date' => date('Y-m-d H:i:s')
        );
        try {
            $this->dasar->insert_table('dp_cuti_request', $arr_insert, 'PAYROLL');
            //BUAT DETAIL REQUEST
            $last_header = $this->m_pengajuan->fetch_last_header_dp($nik);
            foreach ($tanggal as $val_tgl) {
                if ($data['status'] != 500) {
                    $arr_insert_detail = array(
                        'header_id' => $last_header->id,
                        'tgl_cuti' => $val_tgl,
                        'status' => 0,
                        'created_by' => $data_token['data_jwt']->nik,
                        'created_date' => date('Y-m-d H:i:s')
                    );
                    try {
                        $this->dasar->insert_table('cuti_request_detail', $arr_insert_detail, 'PAYROLL');
                        $data['msg'] = 'insert cuti request success';
                    } catch (Exception $e) {
                        $data['status'] = 500;
                        $data['msg'] = 'insert cuti detail request error : ' . $e->getMessage();
                    }
                }
            }
            $data['id_header'] = $last_header->id;
        } catch (Exception $e) {
            $data['status'] = 500;
            $data['msg'] = 'insert cuti header request error : ' . $e->getMessage();
        }
        return $data;
    }
    public function htlIncm_get($tgl)
    {
        $data = $this->model_mahasiswa->income_htl($tgl);
        if ($data) {
            $this->response($data, 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No Data were found'
            ], 404);
        }
    }
    public function cek_jwt_get()
    {
        $data = [];

        $key = "peRkasa$%";
        $headers = $this->input->get_request_header("Authorization");
        // $token = trim($headers, "Bearer ");
        $token = str_replace("Bearer ", "", $headers);

        $decode_jwt = JWT::decode($token, new Key($key, 'HS256'));
        $data['data_jwt'] = $decode_jwt;
        print_r($data);
    }
    public function signin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input("password");

        $data = array(
            "username" => $username,
            "password" => $password,
            "application" => "Absensi Mobile",
            "type" => "json"
        );

        $kirim = $this->endpoint->send_post($data);
        $jdcode = json_decode($kirim['data']);
        if ($jdcode->status) {
            $a = $jdcode->nik;
            $dataLogin = $this->auth->autt($a);
            foreach ($dataLogin as $userss);
            date_default_timezone_set('Asia/Jakarta');

            $key = "peRkasa$%";
            $data_token = array(
                "nik" => $jdcode->nik,
                'nik' => $jdcode->nik,
                'nama' => $userss->EMNAME,
                'level' => $jdcode->result,
                'divisi' => $userss->DIVNAME,
                'id_dept' => $userss->DEPTID,
                'is_login' => true,
                'jam_login' => date('d-m-Y h:i:s')
            );
            $jwt = JWT::encode($data_token, $key, 'HS256');
            $this->auth_absenmobile($jdcode->nik, $userss->DEPTID);

            $sess_data = array(
                'status' => true,
                'nik' => $jdcode->nik,
                'nama' => $userss->EMNAME,
                'level' => $jdcode->result,
                'divisi' => $userss->DIVNAME,
                'id_dept' => $userss->DEPTID,
                'waktu' => date('Y-m-d H:i:s'),
                'hak_approve' => $this->cek_akses_approve($jdcode->nik),
                'JWT' => $jwt
            );
            $this->response($sess_data, 200);
        } else {
            $this->response($jdcode, 404);
        }
    }
    function cek_akses_approve($nik)
    {

        $this->db = $this->load->database("PAYROLL", true);
        $this->db->where('nik', $nik);
        $this->db->from('jenis_approve_detail');
        $query = $this->db->get();
        $data_approval =  $query->result();

        $hak_approve = FALSE;
        if (count((array)$data_approval) > 0) {
            $hak_approve = TRUE;
        }
        return $hak_approve;
    }
    function auth_absenmobile($nik, $id_dept)
    {
        $data = [];
        $data['status'] = 200;
        $data['msg'] = '';

        $data_auth_absen = $this->auth->fetch_auth_absen($nik);
        if (count($data_auth_absen) > 0) {
            //update last login
            $data_update = array('is_login' => 1, 'last_login' => date('Y-m-d H:i:s'));
            $where = "nik = '" . $nik . "'";
            try {
                $this->dasar->update_table('auth_absenmobile', $data_update, $where, 'PAYROLL');
                $data['msg'] = "succes update auth absensi ";
            } catch (Exception $e) {
                $data['status'] = 500;
                $data['msg'] = "failed update auth absensi = " . $e->getMessage();
            }
        } else {
            //simpan data baru
            $arr_insert = array(
                'nik' => $nik,
                'id_dept' => $id_dept,
                'is_login' => 1,
                'last_login' => date('Y-m-d H:i:s'),
                'created_by' => $nik,
                'created_date' => date('Y-m-d H:i:s')
            );
            try {
                $this->dasar->insert_table('auth_absenmobile', $arr_insert, 'PAYROLL');
                $data['msg'] = "succes create auth absensi ";
            } catch (Exception $e) {
                $data['status'] = 500;
                $data['msg'] = "failed create auth absensi = " . $e->getMessage();
            }
        }
        return $data;
    }
    public function logout_get()
    {
        $token = new token();
        $data_token = $token->cek_jwt();

        $data_update = array('is_login' => 0);
        $where = "nik = '" . $data_token['data_jwt']->nik . "'";
        try {
            $this->dasar->update_table('auth_absenmobile', $data_update, $where, 'PAYROLL');
            $stts_json = 200;
            $msg = 'success Logout';
        } catch (Exception $e) {
            $stts_json = 500;
            $msg = 'Failed Logout = ' . $e->getMessage();
        }
        $this->response($msg, $stts_json);
    }
    public function add_post()
    {
    }
    public function hps_delete()
    {
    }
}
