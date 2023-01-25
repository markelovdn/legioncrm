<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                <p>
                    Финансы
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="{{route('payment.show', [\App\Models\Payment::ID_YEAR_PAYMENT])}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ежегодные взносы</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
