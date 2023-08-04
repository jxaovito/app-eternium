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
            <div class="option"
                data-bs-toggle="tooltip" 
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Notificações"
            >
                <i class="ph ph-bell"></i>
            </div>
            <div class="option" 
                data-bs-toggle="tooltip" 
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Configurações"
            >
                <i class="ph ph-gear"></i>
            </div>
        </div>
        <div class="content-profile">
            <div class="content-opc-profile">
                <div class="content">
                    <a href="">
                        <i class="ph ph-user-gear"></i>
                        Configurações do Perfil
                    </a>
                    <a href="">
                        <i class="ph ph-lock-key"></i>
                        Permissões
                    </a>
                    <a href="/logout">
                        <i class="ph ph-sign-out"></i>
                        Sair
                    </a>
                </div>
            </div>
            <div class="profile-photo">
                <img src="{{asset('img/user.png')}}">
            </div>
            <div class="profile-data">
                <span class="data-user">{{session('usuario_nome')}}</span>
                <span class="email-user">{{session('usuario_email')}} <i class="ph ph-caret-down"></i></span>
            </div>
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