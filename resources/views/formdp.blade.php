@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid">
        
       
    </div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Pengajuan DP ') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="/formdp" method="POST" role="form text-left">
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
                                <label for="tgl_awal" class="form-control-label">{{ __('Tanggal dari') }}</label>
                                <div class="@error('tgl_awal')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="" type="text" placeholder="26-04-2022" id="tgl_awal" name="tgl_awal">
                                        @error('tgl_awal')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_sampai" class="form-control-label">{{ __('Tanggal sampai') }}</label>
                                <div class="@error('tgl_sampai')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" placeholder="28-04-2022" id="number" name="tgl_sampai" value="">
                                        @error('tgl_sampai')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="keterangan">{{ 'Keterangan DP' }}</label>
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