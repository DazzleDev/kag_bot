@extends('layouts.user_type.auth')

@section('content')

  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-lg-8">
        <div class="row">
          <div class="col-xl-6 mb-xl-0 mb-4">
            <div class="card bg-transparent shadow-xl">
              <div class="overflow-hidden position-relative border-radius-xl" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
                <span class="mask bg-gradient-dark"></span>
                <div class="card-body position-relative z-index-1 p-3">
                  <h5 class="text-white mt-2 mb-3 pb-2">Petunjuk Penggunaan</h5>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-12 mb-lg-0 mb-4">
            <div class="card mt-4">
              <div class="card-header pb-0 p-3">
                <div class="row">
                  <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">Pengaturan Akun</h6>
                  </div>
                  
                </div>
              </div>
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-md-6 mb-md-0 mb-4">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <!-- <img class="w-10 me-3 mb-0" src="../assets/img/logos/mastercard.png" alt="logo"> -->
                      <h6 class="mb-0">Bagaimana kalau tidak bisa login atau belum memiliki akun ? </h6>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <h6 class="mb-0">Silahkan hubungi IT Department Programmer di ext 5021 atau 5023</h6>
                   </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-lg-0 mb-4">
            <div class="card mt-4">
              <div class="card-header pb-0 p-3">
                <div class="row">
                  <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">Pengajuan Absen Karyawan </h6>
                  </div>
                  
                </div>
              </div>
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-md-6 mb-md-0 mb-4">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <!-- <img class="w-10 me-3 mb-0" src="../assets/img/logos/mastercard.png" alt="logo"> -->
                      <h6 class="mb-0">Bagaimana cara mengisi form untuk melakukan absen  ? </h6>
                    </div>
                  </div>
                  <br>
                  <div class="col-md-6">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <h6 class="mb-0">Silahkan buka menu sesuai dengan kebutuhan di yang ada di dashboard (DP, Cuti, Ijin, Pengajuan)</h6>
                   </div>
                  </div>
                  <br>
                  <div class="col-md-6">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <h6 class="mb-0">Lalu bagaimana cara mengisinya ?</h6>
                   </div>
                  </div>
                  <br>
                  <div class="col-md-6">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <h6 class="mb-0">Isi form sesuai dengan hint yang sudah disediakan (pengisian hampir sama seperti telegram) kemudian kirim</h6>
                   </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-lg-0 mb-4">
            <div class="card mt-4">
              <div class="card-header pb-0 p-3">
                <div class="row">
                  <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">Melihat status pengajuan</h6>
                  </div>
                  
                </div>
              </div>
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-md-6 mb-md-0 mb-4">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <!-- <img class="w-10 me-3 mb-0" src="../assets/img/logos/mastercard.png" alt="logo"> -->
                      <h6 class="mb-0">Bagaimana cara melihat status pengajuan ?  </h6>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <h6 class="mb-0">Silahkan buka menu sesuai dengan kebutuhan di yang ada di dashboard (status)</h6>
                   </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <h6 class="mb-0">Status akan muncul berupa notifikasi (pending, disetujui) oleh yang bersangkutan (SPV atau HRD) </h6>
                   </div>
                  </div>
                </div>
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
  </div>
 
@endsection

