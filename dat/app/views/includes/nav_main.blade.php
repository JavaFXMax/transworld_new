 <nav class="navbar-default navbar-static-side" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    @if(Confide::user()->user_type != 'teller')

                    <li>
                        <a href="{{ URL::to('members') }}"><i class="fa fa-users fa-fw"></i> {{{ Lang::get('messages.members') }}}</a>
                    </li>

                    
                    @endif

                     @if(Confide::user()->user_type == 'teller')

                    <li>
                        <a href="{{ URL::to('/') }}"><i class="fa fa-users fa-fw"></i> {{{ Lang::get('messages.members') }}}</a>
                    </li>

                    @endif

                   
                    

                    
                   
                    


                     


                    




                     


                    
                     
                    
                    
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->