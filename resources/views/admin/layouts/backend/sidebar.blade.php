<!--! [Start] Navigation Manu !-->
    <!--! ================================================================ !-->
    <nav class="nxl-navigation">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('admin.adminDashboard') }}" class="b-brand">
                    <!-- ========   change your logo hear   ============ -->
                    <img src="{{ asset('public/assets/images/logo.png')}}" alt="" style="height: 50px;width: 200px;" class="logo logo-lg" />
                    <img src="{{ asset('public/assets/images/logo-icon.png')}}" alt="" class="logo logo-sm" />
                </a>
            </div>
            <div class="navbar-content">
                <ul class="nxl-navbar">
                    <li class="nxl-item nxl-caption">
                        <label>Navigation</label>
                    </li>
                    <li class="nxl-item">
                        <a href="{{ route('admin.adminDashboard') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-airplay"></i></span>
                            <span class="nxl-mtext">Dashboards</span>
                        </a>
                    </li>
                    @can('Users-Management')
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{ route('admin.users.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-users"></i></span>
                            <span class="nxl-mtext">Users Management</span>
                        </a>
                    </li>
                    @endcan
                    @can('Task-Management')
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{ route('admin.tasks.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather feather-file-text"></i></span>
                            <span class="nxl-mtext">Task Management</span>
                        </a>
                    </li>

                    <!-- <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather feather-file-text"></i></span>
                            <span class="nxl-mtext"> Task Management</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.newinterconnections.create') }}"> New InterConnection</a></li>
                           
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.tradeverifications.create') }}">Trade Verification</a></li>

                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.vendorindex') }}">Agreement Review</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.vendorindex') }}">Agreement Signing</a></li>
                           
                        </ul>
                    </li>  -->
                    @endcan
                    @can('Route-Management')
                     <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="fa-solid fa-route"></i></span>
                            <span class="nxl-mtext"> Route Management</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <!-- <ul class="nxl-submenu">
                            
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.routes.index') }}"> Customer Management</a></li>
                           
                            @if(Auth::user()->type != 2)
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.vendorindex') }}">Vendor Management</a></li>
                            @endif
                        </ul> -->
                        <ul class="nxl-submenu">
                            
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.smsroutes.index') }}"> SMS</a></li>
                        
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.voiceroutes.index') }}">Voice</a></li>
                           
                        </ul>
                    </li> 
                    @endcan 

                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="fa-solid fa-route"></i></span>
                            <span class="nxl-mtext"> NOC</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                       
                        <ul class="nxl-submenu">
                            
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.nocsms.index') }}"> NOC SMS</a></li>
                        
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.nocvoice.index') }}"> NOC Voice</a></li>
                           
                        </ul>
                    </li> 

                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{ route('admin.testresults.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather feather-file-text"></i></span>
                            <span class="nxl-mtext">Test Result</span>
                        </a>
                    </li>


                    @can('Account-Management')
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="fa fa-user"></i></span>
                            <span class="nxl-mtext">Account Management</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.customer-payments.index') }}"> Customer Payment Management</a></li>
                            @if(Auth::user()->type != 2)
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.vendor-payments.index') }}">Vendor Payment Management</a></li>
                            @endif                        
                        </ul>
                    </li>
                    @endcan
                    @can('Technical-Management')
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="fa-solid fa-microchip"></i></span>
                            <span class="nxl-mtext">Technical Details</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.technical-customers.index') }}"> Customer Technical Details</a></li>
                            @if(Auth::user()->type != 2)
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('admin.technical-vendors.index') }}">Vendor Technical Details</a></li>
                            @endif
                        </ul>
                    </li>
                    @endcan
                    @can('Ticket-System')
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{ route('admin.ticket-system.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="fa-solid fa-ticket"></i></span>
                            
                            <span class="nxl-mtext">Ticket System</span>
                        </a>
                    </li>
                    @endcan
                    @can('Role-Management')
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{ route('admin.roles.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                            <span class="nxl-mtext">Role Management</span>
                        </a>
                    </li>
                    @endcan
              
                </ul>
            </div>
        </div>
    </nav>
    <!--! ================================================================ !-->
    <!--! [End]  Navigation Manu !-->