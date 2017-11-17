 <nav class="navbar-default navbar-static-side" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                   @if(Confide::user()->user_type != 'teller') 
                    <li>
                        <a href="{{ URL::to('members/create') }}"><i class="glyphicon glyphicon-user fa-fw"></i> New Member</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('members') }}"><i class="fa fa-users fa-fw"></i> Members</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('membersfee') }}"><i class="glyphicon glyphicon-tags"></i> Members Fees</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('vehicles') }}"><i class="glyphicon glyphicon-list-alt fa-fw"></i> Vehicles</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('tlbpayments') }}"><i class="glyphicon glyphicon-edit"></i> Tlb Payments</a>
                    </li>

                    <!-- <li>
                        <a href="{{ URL::to('assignvehicles') }}"><i class="fa fa-user fa-fw"></i> Assign Vehicle</a>
                    </li>
 -->
                    <li>
                        <a href="{{ URL::to('vehicleincomes') }}"><i class="glyphicon glyphicon-folder-close fa-fw"></i> Vehicle Income</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('vehicleexpenses') }}"><i class="glyphicon glyphicon-check fa-fw"></i> Vehicle Expenses</a>
                    </li>

                    @endif

                    @if(Confide::user()->user_type == 'teller')


                    <li>
                        <a href="{{ URL::to('/') }}"><i class="fa fa-users fa-fw"></i> Members</a>
                    </li>
                    @endif

                    
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->