@extends('layouts.app')
@section('content')

<div class="content_wrapper">
        <div class="container-fluid pt-5 px-sm-5">
            <div class="row">
                <div class="col-sm-10 col-12">
                    <div class="row">
                        <div class="col-sm-12 col-12 align-self-center">
                            <h4 class="semibold_20">Change Password</h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-8 col-12">
                            <div class="sh_card">
                                <div class="">
                                      <div id="resmsg"></div>
                                      @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                          <ul>
                                            @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                            @endforeach
                                          </ul>
                                        </div>
                                      @endif 
                                      @if(session()->has('success'))
                                          <div class="alert alert-success"> {!! session('success') !!} </div>
                                      @endif @if(session()->has('error'))
                                          <div class="alert alert-danger"> {!! session('error') !!} </div>
                                      @endif
                                        <form role="form" id="change-password-form" action="{{ route('change-password') }}" name="change-password-form" method="POST" >
                                          @csrf
                                           <div class="row">
                                                <div class="form-group row">
                                                    <div class="input-group mb-3">
                                                        <div class="group-icon w-100">
                                                            <label for="password">Password</label>
                                                            <input type="password" class="form-control" id="password" name="current-password" placeholder="Password">
                                                            <small class="help-block">{{ $errors->first('password') }}</small>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                        <div class="input-group mb-3">
                                                            <div class="group-icon w-100">
                                                                <label for="confirm_password">Confirm Password</label>
                                                                <input type="password" class="form-control" id="confirm_password" name="new-password" placeholder="Password">
                                                                <small class="help-block">{{ $errors->first('new-password') }}</small>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>  
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button type="submit" class="btn btn-primary">{{ trans('common.save') }}</button>
                                            </div>
                                        </div>
                                    </form>     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
<style>
    .help-block {
    color: #dc3545;
}
</style>
@endsection
@section('script')
<script>
    
</script>
@endsection