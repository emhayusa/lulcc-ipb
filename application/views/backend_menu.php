 <nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <a <?php if($active_menu == "dashboard") echo 'class="active-menu"'; ?>  href="backend/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a <?php if($active_menu == "commodity") echo 'class="active-menu"'; ?>  href="backend/commodity"><i class="fa fa-leaf"></i> Commodity</a>
            </li>
            <li>
                <a <?php if($active_menu == "services") echo 'class="active-menu"'; ?>  href="backend/services"><i class="fa fa-tasks"></i> Services</a>
            </li>
            <li>
                <a <?php if($active_menu == "user") echo 'class="active-menu"'; ?>  href="backend/user"><i class="fa fa-group"></i> User</a>
            </li>
            <li>
                <a <?php if($active_menu == "reporting") echo 'class="active-menu"'; ?>  href="backend/reporting"><i class="fa fa-edit"></i> Reporting</a>
            </li>
            <li>
                <a <?php if($active_menu == "basemap") echo 'class="active-menu"'; ?>  href="backend/basemap"><i class="fa fa-qrcode"></i> Basemap</a>
            </li>
            <li>
                <a <?php if($active_menu == "Administrative Boundary") echo 'class="active-menu"'; ?>><i class="fa fa-sitemap"></i> Administrative Boundary<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a  <?php if($active_menu == "province") echo 'class="active-menu"'; ?>  href="backend/province">Province</a>                        
                    </li>
                    <li>
                        <a <?php if($active_menu == "kabupaten") echo 'class="active-menu"'; ?>  href="backend/kabupaten">District (Kabupaten)</a>  
                    </li>
                    <li>
                        <a <?php if($active_menu == "kecamatan") echo 'class="active-menu"'; ?>  href="backend/kecamatan">Sub District (Kecamatan)</a>  
                    </li>
                </ul>
            </li>

            <li>
                <a <?php if($active_menu == "setting") echo 'class="active-menu"'; ?>  href="backend/setting"><i class="fa fa-cogs"></i> Setting</a>
            </li>
            <li>
                <a <?php if($active_menu == "tutorial") echo 'class="active-menu"'; ?>  href="backend/tutorial"><i class="fa fa-question"></i> Tutorial</a>
            </li>   
            <li>
                <a <?php if($active_menu == "validation") echo 'class="active-menu"'; ?>  href="http://lulcc.ipb.ac.id/ina-alert/" target = "blank"><i class="fa fa-mobile"></i> Mobile Validation</a>
            </li>                                                                                       
        </ul>
    </div>
</nav>
    <!-- /. NAV SIDE  -->