<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
		<li class="nav-item"><a href="/" class="nav-link">Home</a></li>
		
		<?php if(isset($hammer->location[0])){?>
			<li class="nav-item d-none d-sm-inline"><a class="nav-link disabled pl-0 pr-0" href="#" tabindex="-1" aria-disabled="true">&raquo;</a></li>
			<li class="nav-item d-none d-sm-inline<?php if($hammer->location[0]==""){echo " active";}?>"><a href="/<?php echo str_replace("","",$hammer->location[0]); ?>/" class="nav-link"><?php echo str_replace("-"," ",ucwords($hammer->location[0])); ?></a></li>
		<?php } ?>
		
		<?php if(!empty($hammer->location[1])){?>
			 <li class="nav-item d-none d-md-inline"><a class="nav-link disabled pl-0 pr-0" href="#" tabindex="-1" aria-disabled="true">&raquo;</a></li>
			<li class="nav-item d-none d-md-inline<?php if($hammer->location[1]==""){echo " active";}?>"><a href="#" class="nav-link"><?php echo str_replace("-"," ",ucwords($hammer->location[1])); ?></a></li>
		<?php } ?>
		
		<?php if(isset($hammer->location[2])){?>
			<li class="nav-item d-none d-md-inline"><a class="nav-link disabled pl-0 pr-0" href="#" tabindex="-1" aria-disabled="true">&raquo;</a></li>
			<li class="nav-item d-none d-md-inline active"><a href="<?php echo $hammer->location['fullurl'];?>" class="nav-link"><?php echo $hammer->truncate($hammer->location[2], 60,true); ?></a></li>
		<?php } ?>
	</ul>

    <!-- SEARCH FORM --
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>-->
	<?php /*
    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="/logout.php" label="Sign out of Liszt">
          <i class="fas fa-door-open"></i>
        </a>
      </li>
    </ul>*/?>
  </nav>
  <!-- /.navbar -->
