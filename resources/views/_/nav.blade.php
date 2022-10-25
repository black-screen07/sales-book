

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
      <div class="sidebar-brand-icon">
        <i class="fas fa-laptop"></i>
      </div>
      <div class="sidebar-brand-text mx-3">{{ config('global.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item <?= $pIndex=='dashboard' ? 'active' : '' ?>">
      <a class="nav-link" href="<?= route('dashboard'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Tableau de bord</span></a>
    </li>

    <li class="nav-item
        {{  ($pIndex=='customer.all' || $pIndex=='customer.new' || $pIndex=='customer.infos') ? 'active' : '' }}">
        <a class="nav-link" href="<?= route('customer.all'); ?>">
          <i class="fas fa-users"></i>
            <span>Clients</span></a>
        </li>

    <li class="nav-item {{ ($pIndex=='sale.new') ? 'active' : '' }}">
        <a class="nav-link" href="<?= route('sale.new'); ?>">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Caisse</span>
        </a>
    </li>


    @if (Auth::user()->isAdmin())
        <li class="nav-item <?= ($pIndex=='product.all' || $pIndex=='product.new' || $pIndex=='product.infos') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= route('product.all'); ?>">
            <i class="fab fa-fw fa-product-hunt"></i>
            <span>{{ config('global.products') }}</span></a>
        </li>

        <li class="nav-item
        {{  ($pIndex=='supplying.all' || $pIndex=='supplying.new' || $pIndex=='supplying.infos') ? 'active' : '' }}
        ">
        <a class="nav-link" href="<?= route('supplying.all'); ?>">
            <i class="fas fa-fw fa-cart-arrow-down"></i>
            <span>Approvisionements</span></a>
        </li>

        <li class="nav-item <?= ($pIndex=='sale.all' || $pIndex=='sale.infos') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= route('sale.all'); ?>">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Ventes</span></a>
        </li>

        <li class="nav-item
            {{  ($pIndex=='chargeCost.all' || $pIndex=='chargeCost.new' || $pIndex=='chargeCost.infos') ? 'active' : '' }}
            ">
            <a class="nav-link" href="<?= route('chargeCost.all'); ?>">
                <i class="fas fa-fw fa-cart-arrow-down"></i>
                <span>Charges</span></a>
        </li>

        <li class="nav-item
        {{  ($pIndex=='repport.infos' || $pIndex=='repport.infos' || $pIndex=='repport.infos') ? 'active' : '' }}
        ">
        <a class="nav-link" href="<?= route('repport.infos'); ?>">
            <i class="far fa-fw fa-chart-bar"></i>
            <span>Rapport</span></a>
        </li>

        <li class="nav-item
        {{  ($pIndex=='config.all') ? 'active' : '' }}
        ">
        <a class="nav-link" href="<?= route('config.all'); ?>">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Configuration</span></a>
        </li>

        <li class="nav-item
        {{  ($pIndex=='user.all' || $pIndex=='user.new' || $pIndex=='user.infos') ? 'active' : '' }}">
        <a class="nav-link" href="<?= route('user.all'); ?>">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Utilisateurs</span></a>
        </li>
    @endif


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->
