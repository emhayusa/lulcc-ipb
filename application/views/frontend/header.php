
  <!-- Full Body Container -->
  <div id="container">

    <!-- Start Header Section -->
    <header class="clearfix">

      <!-- Start  Logo & Naviagtion  -->
      <div class="navbar navbar-default navbar-top" role="navigation" data-spy="affix" data-offset-top="50">
        <div class="container">
          <div class="navbar-header">
            <!-- Stat Toggle Nav Link For Mobiles -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
            <!-- End Toggle Nav Link For Mobiles -->
            <a class="navbar-text" href="">
              <img alt="" src="assets/frontend/images/logo ecosystem.png">
            </a>
          </div>
          <div class="navbar-collapse collapse">
            <!-- Stat Search -->
            <div class="search-side">
              <a class="show-search"><i class="fa fa-search"></i></a>
              <div class="search-form">
                <form autocomplete="off" role="search" method="get" class="searchform" action="#">
                  <input type="text" value="" name="s" id="s" placeholder="Search the site...">
                </form>
              </div>
            </div>
            <!-- End Search -->
            <!-- Start Navigation List -->
            <ul class="nav navbar-nav navbar-right">
              <li>
                <a <?php if ($active_menu == 'home') echo 'class="active"';?> href="#">Home</a>
              </li>
              <li>
                <a href="frontend/viewer" target ="blank">Map</a>
              </li>
              <li>
                <a <?php  if ($active_menu == 'documentation') echo 'class="active"';?> href="frontend/documentation">Documentation</a>
              </li>
              <li>
                <a <?php //if ($active_menu == 'forests' || $active_menu == 'palm_oil' || $active_menu == 'paddy' || $active_menu == 'rubber' || $active_menu == 'coffe' || $active_menu == 'coccoa') echo 'class="active"';?>>Forest Cover Change</a>
                <ul class="dropdown">
                  <!--
                  <li><a <?php //if ($active_menu == 'forests') echo 'class="active"';?> href="frontend/forests">Forests</a>
                  </li>
                  -->
                  
                  <li><a href="frontend/Forest_Gain">Forest Gain</a>
                  </li>
                  <li><a href="frontend/Forest_Loss">Forest Loss</a>  
                    <ul class="dropdown">
                      <li><a href="frontend/Forest_Loss_Cb_PalmOil">Changed By Palm Oil</a>
                      </li>
                      <li><a href="frontend/Forest_Loss_Cb_Paddy">Changed By Paddy</a>
                      </li>
                      <li><a href="frontend/Forest_Loss_Cb_Rubber">Changed By Rubber</a>
                      </li>
                      <li><a href="frontend/Forest_Loss_Cb_Coffe">Changed By Coffee</a>
                      </li>
                      <li><a href="frontend/Forest_Loss_Cb_Cacao">Changed By Cacao</a>
                      </li>                  
                      <li><a href="frontend/Forest_Loss_Cb_NonCommodity">Changed By Non-Commodity</a>
                      </li>
                    </ul>
                  </li> 
                </ul>
              </li>
			  <li>
                <a <?php //if ($active_menu == 'forests' || $active_menu == 'palm_oil' || $active_menu == 'paddy' || $active_menu == 'rubber' || $active_menu == 'coffe' || $active_menu == 'coccoa') echo 'class="active"';?>>Commodity Distribution</a>
                <ul class="dropdown">
                  <!--
                  <li><a <?php //if ($active_menu == 'forests') echo 'class="active"';?> href="frontend/forests">Forests</a>
                  </li>
                  -->
                      <li><a href="frontend/Commodity_PalmOil">Palm Oil</a>
                      </li>
                      <li><a href="frontend/Commodity_Paddy">Paddy</a>
                      </li>
                      <li><a href="frontend/Commodity_Rubber">Rubber</a>
                      </li>
                      <li><a href="frontend/Commodity_Coffe">Coffee</a>
                      </li>
                      <li><a href="frontend/Commodity_Cacao">Cacao</a>
                      </li>                  
                </ul>
              </li>
              <li><a <?php  if ($active_menu == 'contact') echo 'class="active"';?>  href="frontend/contact">Contact</a>
              </li>
            </ul>
            <!-- End Navigation List -->
          </div>
        </div>
		<?php
		/*
        <!-- Mobile Menu Start -->
        <ul class="wpb-mobile-menu">
          <li>
            <a class="active" href="index.html">Home</a>
            <ul class="dropdown">
              <li><a href="index-01.html">Home Version 1</a>
              </li>
              <li><a href="index-02.html">Home Version 2</a>
              </li>
              <li><a href="index-03.html">Home Version 3</a>
              </li>
              <li><a href="index-04.html">Home Version 4</a>
              </li>
              <li><a href="index-05.html">Home Version 5</a>
              </li>
              <li><a href="index-06.html">Home Version 6</a>
              </li>
              <li><a href="index-07.html">Home Version 7</a>
              </li>
              <li><a href="index-08.html">HSome Version 8</a>
              </li>
              <li><a href="index-09.html">Home Version 9</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="about.html">Pages</a>
            <ul class="dropdown">
              <li><a href="about.html">About</a>
              </li>
              <li><a href="services.html">Services</a>
              </li>
              <li><a href="right-sidebar.html">Right Sidebar</a>
              </li>
              <li><a href="left-sidebar.html">Left Sidebar</a>
              </li>
              <li><a href="404.html">404 Page</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#">Shortcodes</a>
            <ul class="dropdown">
              <li><a href="tabs.html">Tabs</a>
              </li>
              <li><a href="buttons.html">Buttons</a>
              </li>
              <li><a href="forms.html">Forms</a>
              </li>
              <li><a href="action-box.html">Action Box</a>
              </li>
              <li><a href="testimonials.html">Testimonials</a>
              </li>
              <li><a href="latest-posts.html">Latest Posts</a>
              </li>
              <li><a href="latest-projects.html">Latest Projects</a>
              </li>
              <li><a href="pricing.html">Pricing Tables</a>
              </li>
              <li><a href="animated-graphs.html">Animated Graphs</a>
              </li>
              <li><a href="accordion-toggles.html">Accordion & Toggles</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="portfolio-3.html">Portfolio</a>
            <ul class="dropdown">
              <li><a href="portfolio-2.html">2 Columns</a>
              </li>
              <li><a href="portfolio-3.html">3 Columns</a>
              </li>
              <li><a href="portfolio-4.html">4 Columns</a>
              </li>
              <li><a href="single-project.html">Single Project</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="blog.html">Blog</a>
            <ul class="dropdown">
              <li><a href="blog.html">Blog - right Sidebar</a>
              </li>
              <li><a href="blog-left-sidebar.html">Blog - Left Sidebar</a>
              </li>
              <li><a href="single-post.html">Blog Single Post</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="contact.html">Contact</a>
          </li>
        </ul>
        <!-- Mobile Menu End -->
		*/
		?>
      </div>
      <!-- End Header Logo & Naviagtion -->

    </header>
    <!-- End Header Section -->