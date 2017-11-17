 <nav class="navbar-default navbar-static-side" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                    
                    <li>
                        <a href="{{ URL::to('users') }}"><i class="fa fa-user fa-fw"></i> System Users</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('roles') }}"><i class="fa fa-bookmark fa-fw"></i> System Roles</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('tellers') }}"><i class="fa fa-group fa-fw"></i> Tellers</a>
                    </li>

                   <!--
                    <li>
                        <a href="{{ URL::to('import') }}"><i class="fa fa-upload fa-fw"></i> Bulk Import</a>
                    </li>
                    -->

                    <li>
                        <a href="{{ URL::to('audits') }}"><i class="fa fa-list fa-fw"></i> Audit Trail</a>
                    </li>

                    <!--
                    <li>
                        <a href="{{ URL::to('backups') }}"><i class="fa fa-download fa-fw"></i> Backup & Restore</a>
                    </li>
-->
                    <li>
                        <a href="{{ URL::to('license') }}"><i class="fa fa-home fa-fw"></i> Licensing</a>
                    </li>


                    <li>
                        <a href="{{ URL::to('automated/loans') }}"><i class="fa fa-cogs fa-fw"></i> Auto process Loans</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('automated/savings') }}"><i class="fa fa-cogs fa-fw"></i> Auto process Savings</a>
                    </li>


                    <li>
                        <a href="{{ URL::to('backup') }}"><i class="fa fa-cogs fa-fw"></i> Backup Database</a>
                    </li>
                    

                   
                     
                    


                     


                    




                     


                    
                     
                    
                    
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->