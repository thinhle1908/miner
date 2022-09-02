@extends('layouts.user-frontend.user-dashboard')
@section('content')
  <div class="clearfix"></div>
  <div class="clearfix"></div>
  <section  style="margin-top: 100px;">
      <div class="container">
        <div class="row">
  
  <div class="col-md-12">
      
      <div class="col-md-8 col-md-offset-2">
         <div class="panel panel-primary">
          <div class="panel-heading">Verify Google Authenticator Code</div>
          <div class="panel-body">
            <form action="{{route('go2fa.verify') }}" method="POST">
              {{csrf_field()}}
              <div class="form-group">
                <input type="text" class="form-control" name="code" placeholder="Enter Google Authenticator Code"> 
              </div>
               <div class="form-group">
                <button type="submit" class="btn btn-lg btn-success btn-block">Verify</button>
              </div>
            </form>
          </div>
        </div>
      </div>

</div>
</div>
</div>
</section>

@endsection
         
            
         