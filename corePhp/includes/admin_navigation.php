<header>
    <ul id="nav-mobile" class="sidenav sidenav-fixed">
        <li><a href="home" class="<?=(($args && $args['active_link'] == 'home')? 'active' : '')?>"><i class="material-icons">home</i> Home</a></li>
        <li><a href="category" class="<?=(($args && $args['active_link'] == 'category')? 'active' : '')?>"><i class="material-icons">list</i> Categoties</a></li>
        <li><a href="tutorial" class="<?=(($args && $args['active_link'] == 'category')? 'active' : '')?>"><i class="material-icons">description</i> Tutorial</a></li>
    </ul>
    <div class="navbar-fixed">
        <nav class="navbar top-menu light-blue darken-2">
            <div class="nav-wrapper"><a href="#!" class="brand-logo grey-text text-darken-4"><?=$this->site_name?></a>
            <ul id="top-nav" class="right">
                <li><?=ucfirst($this->logged_user)?></li>
                <li><a class='dropdown-trigger' href='#' data-target='dropdown1'><i class="material-icons">settings</i></a></li>
            </ul>
            
        </nav>
    </div>
    <ul id='dropdown1' class='dropdown-content'>
        <li><a href="javascript:void(0);"><i class="material-icons">face</i><?=ucfirst($this->logged_user)?></a></li>
        <li><a href="logout.php" class="">Logout</a></li>
    </ul>
</header>
<div class="main">