@include('includes.head')

<?php $organization = Organization::find(1);?>

<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <div class="login-panel panel panel-default">
                      
                    <div class="panel-body">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="50%">
               
                        {{ Confide::makeLoginForm()->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>