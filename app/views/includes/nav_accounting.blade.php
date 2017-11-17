 <nav class="navbar-default navbar-static-side" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                    
                    <li>
                        <a href="{{ URL::to('accounts') }}"><i class="glyphicon glyphicon-user fa-fw"></i> Chart of Accounts</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('journals') }}"><i class="fa fa-barcode fa-fw"></i> Journal Entries</a>
                    </li>


                    <li>
                        <a href="{{ URL::to('journals/create') }}"><i class="fa fa-plus-sign fa-fw"></i> Add Journal Entry</a>
                    </li>

                    
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->