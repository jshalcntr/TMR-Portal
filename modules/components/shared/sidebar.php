<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/tmr-portal/index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-ticket"></i> -->
            <img src="/tmr-portal/assets/img/tmr-logo.png" alt="" srcset="" width="50px">
        </div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <!-- <li class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'dashboard.php') != false ? 'active' : '' ?>">
        <a class="nav-link" href="/tmr-portal/index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li> -->
    <div class="side-item">
        <ul class="<?= strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false ? 'active' : '' ?>">
            <li class="iso-pro ">
                <a href="/tmr-portal/index.php">
                    <span></span>
                    <span></span>
                    <span></span>
                    <i class="fas fa-fw fa-tachometer-alt svg"></i>
                    <div class="text">Dashboard</div>
                </a>

            </li>

        </ul>
    </div>
    <?php if ($authRole == "S-ADMIN" || $authorizations['accounts_view']): ?>
        <hr class="sidebar-divider">

        <div class="sidebar-heading">Accounts Management</div>
        <div class="side-item">
            <ul class="<?= strpos($_SERVER['REQUEST_URI'], 'accounts.php') !== false ? 'active' : '' ?>">
                <li class="iso-pro">
                    <a href="/tmr-portal/modules/account-management/accounts.php">
                        <span></span>
                        <span></span>
                        <span></span>
                        <i class="fas fa-users-cog svg"></i>
                        <div class="text">Accounts</div>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($authorizations['inventory_view']): ?>
        <hr class="sidebar-divider">

        <div class="sidebar-heading">Inventory Management</div>

        <!-- <li class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'inventory.php') != false ? 'active' : '' ?> ?>">
            <a class="nav-link" href="/tmr-portal/views/admin/inventory-management/inventory.php">
                <i class="fas fa-warehouse"></i>
                <span>Inventory</span></a>
        </li> -->
        <div class="side-item">
            <ul class="<?= strpos($_SERVER['REQUEST_URI'], 'inventory.php') !== false ? 'active' : '' ?>">
                <li class="iso-pro ">
                    <a href="/tmr-portal/modules/inventory-management/inventory.php">
                        <span></span>
                        <span></span>
                        <span></span>
                        <i class="fas fa-fw fa-warehouse svg"></i>
                        <div class="text">Inventory</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="side-item">
            <ul class="<?= strpos($_SERVER['REQUEST_URI'], 'disposal.php') !== false ? 'active' : '' ?>">
                <li class="iso-pro">
                    <a href="/tmr-portal/modules/inventory-management/disposal.php">
                        <span></span>
                        <span></span>
                        <span></span>
                        <i class="fa-solid fa-trash-can-clock svg fa-fw fa-2x"></i>
                        <div class="text">Disposal</div>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Ticketing System</div>

    <!-- <li class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'ticketing.php') !== false ? 'active' : '' ?>">
        <a href="<?= $authRole == "ADMIN" ? "/tmr-portal/views/admin/ticketing-system/ticketing.php" : "/tmr-portal/views/user/ticketing-system/ticketing.php" ?>" class="nav-link">
            <i class="fas fa-ticket"></i>
            <span>Ticketing System</span>
        </a>
    </li> -->

    <!-- /* From Uiverse.io by MijailVillegas */  -->
    <div class="side-item">
        <ul class="<?= strpos($_SERVER['REQUEST_URI'], 'ticketing.php') !== false ? 'active' : '' ?>">
            <li class="iso-pro">

                <a href="<?= $authRole == "ADMIN" ? "/tmr-portal/views/admin/ticketing-system/ticketing.php" : ($authRole == "USER" ? "/tmr-portal/views/user/ticketing-system/ticketing.php" : ($authRole == "HEAD" ? "/tmr-portal/views/user/ticketing-system/ticketing.php" :
                                "/tmr-portal/views/s-admin/ticketing-system/ticketing.php")) ?>">
                    <span></span>
                    <span></span>
                    <span></span>
                    <i class="fas fa-ticket svg"></i>
                    <div class="text">Ticketing</div>
                </a>
            </li>

        </ul>
    </div>
    <!-- End From Uiverse.io by MijailVillega -->

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Interface
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Utilities Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li> -->

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Addons
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Charts -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li> -->

    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> -->

    <!-- Divider -->
    <!-- <hr class="sidebar-divider d-none d-md-block"> -->

    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline fixed-bottom-left">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->

    <!-- Sidebar Message -->
    <!-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> -->

</ul>
<!-- End of Sidebar -->

<div id="notification-container" class="notification-container"></div>