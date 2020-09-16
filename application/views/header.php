<div class="container">
	<nav class="navbar navbar-expand navbar-light bg-light">
	  <a class="navbar-brand" href="#">
		<img src="assets/images/<?php echo $logo;?>" class="d-inline-block align-top" id=id="top">
		
	  </a>
	</nav>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample08">
      <ul class="navbar-nav mr-auto"></ul>
          <ul class="navbar-nav">
		    <li class="nav-item">
				<a class="nav-link mx-3 <?php if($active_menu == "frontend") echo "active-menu"; ?>" href="">Frontend</a>			
		    </li>
          	<li class="nav-item">
				<a class="nav-link mx-3 <?php if($active_menu == "map") echo "active-menu"; ?>" href="frontend/viewer">Map</a>			
		    </li>
	
          <?php 
			if($this->session->userdata('status') != "loginuser"){
			?>
		<li class="nav-item">
			<a class="nav-link mx-3 <?php if($active_menu == "login") echo "active-menu"; ?>" href="login">Login</a>
		</li>
		<?php
			}else{
			/*
			?>
			<li class="nav-item">
				<a class="nav-link mx-3 <?php if($active_menu == "profil") echo "active-menu"; ?>" href="profil">Profil</a>
			</li>
			*/
			?>
			<li class="nav-item">
				<a class="nav-link mx-3" href="login/logout">Logout</a>
			</li>
			<?php 
			}?>
	  </ul>
         
    </div>
</nav>
</div>