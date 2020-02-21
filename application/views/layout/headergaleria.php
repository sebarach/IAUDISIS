
<body class="app sidebar-fixed aside-menu-off-canvas aside-menu-hidden header-fixed ">
    <header class="app-header navbar">
        <a class="navbar-brand" >
            <strong>
                <img alt="user" width="85%" src="<?php echo  site_url(); ?>/PNG/logo-iaudisis.png">
            </strong>
        </a>
        <ul class="nav navbar-nav ">

            <?php 
                    if(isset($Cliente)){
                        echo '<li class="nav-item ">
                            <a class="nav-link h6" >
                                <i class="mdi mdi-factory"></i> '; 
                            echo $NombreCliente; 
                            echo'                                
                            </a>
                        </li>'; 
                    }
            ?>                      


            <li class="nav-item ">
                <!-- dropdown-menu -->
            </li>
            <!-- end navitem -->

            <!-- end nav-item -->


        </ul>

       
    </header>
</body>