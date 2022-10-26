@if (Route::has('register'))
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="/" class="nav-link">
                <p>
                    Зарегистрироваться
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right"></span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/user/create?parent" class="nav-link">
                        <i class="fas fa-user-friends"></i>
                        <p>Родитель</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/user/create?coach" class="nav-link">
                        <i class="fas fa-trophy"></i>
                        <p>Тренер</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/user/create?organization_chairman" class="nav-link">
                        <i class="fas fa-trophy"></i>
                        <p>Руководитель организации</p>
                    </a>
                </li>


            </ul>
        </li>
    </ul>
@endif
