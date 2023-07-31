<div class="top-nav">
    <div class="content-nav">
        <div class="content-logo">
            <img src="{{asset('clientes/'.session('conexao_id').'/img/logo_menu.png')}}">
        </div>
        <div class="content-search">
            @if(isset($pagina) && $pagina == 'agenda')
                <div class="search-agenda">
                    <input type="text" placeholder="Pesquise aqui...">
                </div>
            @endif
        </div>
        <div class="others-options">
            <div class="option">
                <i class="ph ph-bell"></i>
            </div>
        </div>
        <div class="content-profile">

        </div>
    </div>
</div>

<div class="lateral-nav">
    <div class="content-nav">
        <div class="content-expand">
            <i class="ph ph-caret-left"></i>
        </div>
        <div class="content-menus">
            <a href="" class="menu {{ isset($pagina) && $pagina == 'agenda' ? 'active' : '' }}">
                <i class="ph ph-calendar-blank"></i>
                <span>Agenda</span>
            </a>
        </div>
    </div>
</div>