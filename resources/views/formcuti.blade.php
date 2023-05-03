@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid">
        
       
    </div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Pengajuan Cuti ') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="/user-profile" method="POST" role="form text-left">
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
                                <label for="tgl_cuti" class="form-control-label">{{ __('Tanggal dari') }}</label>
                                <div class="@error('tgl_cuti')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="" type="text" placeholder="28-04-2022" id="tgl_cuti" name="tgl_cuti">
                                        @error('tgl_cuti')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_selesai" class="form-control-label">{{ __('Tanggal sampai') }}</label>
                                <div class="@error('tgl_selesai')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="tel" placeholder="29-04-2022" id="number" name="tgl_selesai" value="">
                                        @error('tgl_selesai')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="about">{{ 'Keterangan Cuti' }}</label>
                        <div class="@error('user.about')border border-danger rounded-3 @enderror">
                            <textarea class="form-control" id="about" rows="3" placeholder="Tulis keterangan disini" name="about_me">{{ auth()->user()->about_me }}</textarea>
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