@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid">
        
       
    </div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Pengajuan Perijinan ') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="" method="POST" role="form text-left">
                    @csrf
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis" class="form-control-label">{{ __('Jenis Perijinan') }}</label>
                                <div class="@error('jenis')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="" type="text" placeholder="Jenis Perijinan" id="jenis" name="jenis">
                                        @error('jenis')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl" class="form-control-label">{{ __('Tanggal') }}</label>
                                <div class="@error('tgl')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="" type="text" placeholder="Contoh : 2022-09-30" id="tgl" name="tgl">
                                        @error('tgl')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_dari" class="form-control-label">{{ __('Dari jam') }}</label>
                                <div class="@error('jam_dari')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" placeholder="07:00" id="jam_dari" name="phone" value="">
                                        @error('jam_dari')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_sampai" class="form-control-label">{{ __('Sampai jam') }}</label>
                                <div class="@error('jam_sampai') border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" placeholder="09:00" id="jam_sampai" name="location" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">{{ 'Keterangan Izin' }}</label>
                        <div class="@error('keterangan')border border-danger rounded-3 @enderror">
                            <textarea class="form-control" id="keterangan" rows="3" placeholder="Tulis keterangan disini" name="keterangan"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Ajukan' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection