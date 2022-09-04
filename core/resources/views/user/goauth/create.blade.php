@extends('layouts.user-frontend.user-dashboard')
@section('content')    	
<div class="col-md-8 col-md-offset-2">
<h3 class="text-bold text-center">Trình xác thực hai yếu tố
</h3>
		
@if(Auth::user()->tauth == '1')
<div class="panel panel-inverse">
  <div class="panel-body text-center">
		<div class="form-group">
			<label style="text-transform: capitalize;">Sử dụng trình xác thực google để quét mã QR bên dưới hoặc sử dụng mã bên dưới</label>
<a class="btn btn-success btn-md" href="" target="_blank">TẢI ỨNG DỤNG</a>

			<div class="input-group">
			<input type="text" value="{{$prevcode}}" class="form-control input-lg" id="code" readonly>
				<span class="input-group-addon btn btn-success" id="copybtn">Sao chép</span>
			</div>	
		</div>
		<div class="form-group">
             <img src="{{$prevqr}}">
        </div>
		<button type="button" class="btn btn-block btn-lg btn-danger" data-toggle="modal" data-target="#disableModal">Tắt trình xác thực hai yếu tố</button>	
  </div>
</div>
@else
<div class="panel panel-info">
<div class="panel-body text-center">
		<div class="form-group">
			<label style="text-transform: capitalize;">sử dụng trình xác thực google để quét mã QR bên dưới hoặc sử dụng mã bên dưới</label><br/>
<a class="btn btn-success btn-md" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">TẢI ỨNG DỤNG</a>
<hr/>
			<div class="input-group">
			<input type="text" name="key" value="{{$secret}}" class="form-control input-lg" id="code" readonly>
				<span class="input-group-addon btn btn-success" id="copybtn">Sao chép</span>
			</div>	
		</div>
		<div class="form-group">
             <img src="{{$qrCodeUrl}}">
        </div>
		<button type="button" class="btn btn-block btn-lg btn-primary" data-toggle="modal" data-target="#enableModal">Bật trình xác thực hai yếu tố</button>	
</div>
</div>
@endif
</div>

<!--Copy Data -->
<script type="text/javascript">
  document.getElementById("copybtn").onclick = function() 
  {
    document.getElementById('code').select();
    document.execCommand('copy');
  }
</script>


<!--Enable Modal -->
<div id="enableModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Verify Your OTP</h4>
      </div>
      <div class="modal-body">
        <form action="{{route('go2fa.create')}}" method="POST">
              {{csrf_field()}}
              <div class="form-group">
                <input type="hidden" name="key" value="{{$secret}}">
                <input type="text" class="form-control" name="code" placeholder="Enter Google Authenticator Code"> 
              </div>
               <div class="form-group">
                <button type="submit" class="btn btn-lg btn-success btn-block">Verify</button>
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!--Disable Modal -->
<div id="disableModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Verify Your OTP to Disable</h4>
      </div>
      <div class="modal-body">
           <form action="{{route('disable.2fa')}}" method="POST">
              {{csrf_field()}}
              <div class="form-group">
                <input type="text" class="form-control" name="code" placeholder="Enter Google Authenticator Code"> 
              </div>
               <div class="form-group">
                <button type="submit" class="btn btn-lg btn-success btn-block">Verify</button>
              </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection