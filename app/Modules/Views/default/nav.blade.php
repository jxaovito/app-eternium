@php
if(!session('menu') || session('menu') == 'mostrar'){
    $mostrar_menu = true;
    $titulo = 'inline-block';
    $width_i = '20%';
    $width_nav_lateral = '15%';
    $width_content_page = '82.5%';
    $btn_action_menu = 'ph-caret-left';
    $tooltip = 'Ocultar Menu';

}else{
    $mostrar_menu = false;
    $titulo = 'none';
    $width_i = '90%';
    $width_nav_lateral = '4%';
    $width_content_page = '92.5%';
    $btn_action_menu = 'ph-caret-right';
    $tooltip = 'Mostrar Menu';
}
@endphp
<style>
    .lateral-nav{
        width:{{$width_nav_lateral}};
    }
    .content-page{
        width:{{$width_content_page}};
    }
    .lateral-nav .content-nav .content-menus a span{
        display:{{$titulo}};
    }
    .lateral-nav .content-menus .menu i{
        width:{{$width_i}};
    }
</style>
<form id="form_menu">
    @csrf
</form>
<div class="top-nav">
    <div class="content-nav">
        <div class="content-logo">
            <img src="{{asset('clientes/'.session('conexao_id').'/img/'.array_column(session('config_dados'), 'valor', 'variavel')['logo'])}}">
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

            @php
                $modulo='configuracao';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            @endphp

            <div class="option opc_config_nav" 
                data-bs-toggle="tooltip" 
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Configurações"
            >
                <i class="ph ph-gear"></i>
            </div>

            <div class="content-config">
                <div class="content">
                    <a href="/configuracao">
                        <i class="ph ph-user-gear"></i>
                        Configurações da Empresa
                    </a>

                    <a href="/configuracao/agenda">
                        <i class="ph ph-calendar-blank"></i>
                        Configurações da Agenda
                    </a>
                </div>
            </div>
            @php endif @endphp
        </div>
        <div class="content-profile">
            <div class="content-opc-profile">
                <div class="content">
                    <a href="">
                        <i class="ph ph-user-gear"></i>
                        Configurações do Perfil
                    </a>

                    @php
                        $modulo='permissao';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                            return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                        }))>0):
                    @endphp
                        <a href="/permissao">
                            <i class="ph ph-lock-key"></i>
                            Permissões
                        </a>
                    @php endif @endphp

                    @php
                        $modulo='usuario';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                            return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                        }))>0):
                    @endphp
                        <a href="/usuario">
                            <i class="ph ph-users"></i>
                            Usuários
                        </a>
                    @php endif @endphp

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
                <span class="data-user w-100 text-align-center">{{session('usuario_nome')}}</span>
                <span class="email-user">{{session('usuario_email')}} <i class="ph ph-caret-down"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="lateral-nav">
    <div class="content-nav">
        <div class="content-expand">
            <i
                class="ph {{$btn_action_menu}}"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{$tooltip}}"
            ></i>
        </div>
        <div class="content-menus">
            <?php
                $modulo='agenda';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'agenda' ? '/agenda' : '#' }}" 
                class="menu {{ isset($pagina) && $pagina == 'agenda' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Agenda"
                        '
                    :
                        ''
                ?>
                data-tooltip="Agenda"
            >
                <i class="ph ph-calendar-blank"></i>
                <span>Agenda</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='paciente';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'paciente' ? '/paciente' : '#' }}" 
                class="menu {{ isset($pagina) && $pagina == 'paciente' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Pacientes"
                        '
                    :
                        ''
                ?>
                data-tooltip="Pacientes"
            >
                <i class="ph ph-users-three"></i>
                <span>Pacientes</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='profissional';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'profissional' ? '/profissional' : '#' }}" 
                class="menu {{ isset($pagina) && $pagina == 'profissional' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Profissionais"
                        '
                    :
                        ''
                ?>
                data-tooltip="Profissionais"
            >
                <i class="ph ph-user-list"></i>
                <span>Profissionais</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='convenio';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'convenio' ? '/convenio' : '#' }}" 
                class="menu {{ isset($pagina) && $pagina == 'convenio' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Convênios"
                        '
                    :
                        ''
                ?>
                data-tooltip="Convênios"
            >
                <i class="ph ph-identification-card"></i>
                <span>Convênios</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='especialidade';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'especialidade' ? '/especialidade' : '#' }}" 
                class="menu {{ isset($pagina) && $pagina == 'especialidade' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Especialidades"
                        '
                    :
                        ''
                ?>
                data-tooltip="Especialidades"
            >
                <i class="ph ph-bookmarks"></i>
                <span>Especialidades</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='procedimento';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'procedimento' ? '/procedimento' : '#' }}" 
                class="menu {{ isset($pagina) && $pagina == 'procedimento' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Procedimentos"
                        '
                    :
                        ''
                ?>
                data-tooltip="Procedimentos"
            >
                <i class="ph ph-heart-half"></i>
                <span>Procedimentos</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='tratamento';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'tratamento' ? '/tratamento' : '#' }}" 
                class="menu {{ isset($pagina) && $pagina == 'tratamento' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Tratamentos"
                        '
                    :
                        ''
                ?>
                data-tooltip="Tratamentos"
            >
                <i class="ph ph-hand-heart"></i>
                <span>Tratamentos</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='financeiro';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'financeiro' ? '/financeiro' : '#' }}" 
                class="menu {{ isset($pagina) && $pagina == 'financeiro' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Financeiro"
                        '
                    :
                        ''
                ?>
                data-tooltip="Financeiro"
            >
                <i class="ph ph-currency-dollar"></i>
                <span>Financeiro</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='relatorio';$funcao='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
                    return$item['modulo']===$modulo&&$item['funcao']===$funcao;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'relatorio' ? '/relatorio' : '#' }}" 
                class="menu {{ isset($pagina) && $pagina == 'relatorio' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Relatórios"
                        '
                    :
                        ''
                ?>
                data-tooltip="Relatórios"
            >
                <i class="ph ph-scroll"></i>
                <span>Relatórios</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>