<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{route('competitions.index')}}" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                    Соревнования
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">6</span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('competitions.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Все</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                    Настройки
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">6</span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('role-user.create')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Роли</p>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</nav>
