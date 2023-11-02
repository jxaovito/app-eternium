@php
if(!session('menu') || session('menu') == 'mostrar'){
    $mostrar_menu = true;
    $titulo = 'inline-block';
    $width_i = '20%';
    $width_nav_lateral = '15%';
    $width_content_page = '82.5%';
    $btn_action_menu = 'ph-caret-left';
    $tooltip = mensagem('menu_msg11');

}else{
    $mostrar_menu = false;
    $titulo = 'none';
    $width_i = '90%';
    $width_nav_lateral = '4%';
    $width_content_page = '92.5%';
    $btn_action_menu = 'ph-caret-right';
    $tooltip = mensagem('menu_msg10');
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
            <a href="../"><img src="{{asset('clientes/'.session('conexao_id').'/img/'.array_column(session('config_dados'), 'valor', 'variavel')['logo'])}}"></a>
        </div>
        <div class="content-search">
            @if(isset($pagina) && $pagina == 'agenda')
                <div class="search-agenda">
                    <input type="text" placeholder="{{mensagem('menu_msg12')}}...">
                </div>
            @endif
        </div>
        <div class="others-options">
            <div class="option"
                data-bs-toggle="tooltip" 
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{mensagem('menu_msg13')}}"
            >
                <i class="ph ph-bell"></i>
            </div>

            @php
                $modulo='configuracao';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            @endphp

            <div class="option opc_config_nav" 
                data-bs-toggle="tooltip" 
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{mensagem('menu_msg14')}}"
            >
                <i class="ph ph-gear"></i>
            </div>

            <div class="content-config">
                <div class="content">
                    <a href="/configuracao">
                        <i class="ph ph-user-gear"></i>
                        {{mensagem('menu_msg15')}}
                    </a>

                    <a href="/configuracao/agenda">
                        <i class="ph ph-calendar-blank"></i>
                        {{mensagem('menu_msg16')}}
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
                        {{mensagem('menu_msg17')}}
                    </a>

                    @php
                        $modulo='permissao';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                            return$item['modulo']===$modulo&&$item['funcao']===$func;
                        }))>0):
                    @endphp
                        <a href="/permissao">
                            <i class="ph ph-lock-key"></i>
                            {{mensagem('menu_msg18')}}
                        </a>
                    @php endif @endphp

                    @php
                        $modulo='usuario';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                            return$item['modulo']===$modulo&&$item['funcao']===$func;
                        }))>0):
                    @endphp
                        <a href="/usuario">
                            <i class="ph ph-users"></i>
                            {{mensagem('menu_msg19')}}
                        </a>
                    @php endif @endphp

                    <a href="/logout">
                        <i class="ph ph-sign-out"></i>
                        {{mensagem('menu_msg20')}}
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
                $modulo='agenda';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'agenda' ? '/agenda' : ($funcao != 'index' ? '/agenda' : '#') }}" 
                class="menu {{ isset($pagina) && $pagina == 'agenda' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="'.mensagem('menu_msg1').'"
                        '
                    :
                        ''
                ?>
                data-tooltip="Agenda"
            >
                <i class="ph ph-calendar-blank"></i>
                <span>{{mensagem('menu_msg1')}}</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='paciente';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'paciente' ? '/paciente' : ($funcao != 'index' ? '/paciente' : '#') }}" 
                class="menu {{ isset($pagina) && $pagina == 'paciente' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="'.mensagem('menu_msg2').'"
                        '
                    :
                        ''
                ?>
                data-tooltip="Pacientes"
            >
                <i class="ph ph-users-three"></i>
                <span>{{mensagem('menu_msg2')}}</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='profissional';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'profissional' ? '/profissional' : ($funcao != 'index' ? '/profissional' : '#') }}" 
                class="menu {{ isset($pagina) && $pagina == 'profissional' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="'.mensagem('menu_msg3').'"
                        '
                    :
                        ''
                ?>
                data-tooltip="Profissionais"
            >
                <i class="ph ph-user-list"></i>
                <span>{{mensagem('menu_msg3')}}</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='convenio';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'convenio' ? '/convenio' : ($funcao != 'index' ? '/convenio' : '#') }}" 
                class="menu {{ isset($pagina) && $pagina == 'convenio' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="'.mensagem('menu_msg4').'"
                        '
                    :
                        ''
                ?>
                data-tooltip="Convênios"
            >
                <i class="ph ph-identification-card"></i>
                <span>{{mensagem('menu_msg4')}}</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='especialidade';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'especialidade' ? '/especialidade' : ($funcao != 'index' ? '/especialidade' : '#') }}" 
                class="menu {{ isset($pagina) && $pagina == 'especialidade' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="'.mensagem('menu_msg5').'"
                        '
                    :
                        ''
                ?>
                data-tooltip="Especialidades"
            >
                <i class="ph ph-bookmarks"></i>
                <span>{{mensagem('menu_msg5')}}</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='procedimento';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'procedimento' ? '/procedimento' : ($funcao != 'index' ? '/procedimento' : '#') }}" 
                class="menu {{ isset($pagina) && $pagina == 'procedimento' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="'.mensagem('menu_msg6').'"
                        '
                    :
                        ''
                ?>
                data-tooltip="Procedimentos"
            >
                <i class="ph ph-heart-half"></i>
                <span>{{mensagem('menu_msg6')}}</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='tratamento';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'tratamento' ? '/tratamento' : ($funcao != 'index' ? '/tratamento' : '#') }}" 
                class="menu {{ isset($pagina) && $pagina == 'tratamento' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="'.mensagem('menu_msg7').'"
                        '
                    :
                        ''
                ?>
                data-tooltip="Tratamentos"
            >
                <i class="ph ph-hand-heart"></i>
                <span>{{mensagem('menu_msg7')}}</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='financeiro';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'financeiro' ? '/financeiro' : ($funcao != 'index' ? '/financeiro' : '#') }}" 
                class="menu {{ isset($pagina) && $pagina == 'financeiro' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="'.mensagem('menu_msg8').'"
                        '
                    :
                        ''
                ?>
                data-tooltip="Financeiro"
            >
                <i class="ph ph-currency-dollar"></i>
                <span>{{mensagem('menu_msg8')}}</span>
            </a>
            <?php endif; ?>

            <?php
                $modulo='relatorio';$func='index';if(count(array_filter(session('permissoes'),function($item)use($modulo, $func){
                    return$item['modulo']===$modulo&&$item['funcao']===$func;
                }))>0):
            ?>
            <a 
                href="{{ isset($pagina) && $pagina != 'relatorio' ? '/relatorio' : ($funcao != 'index' ? '/relatorio' : '#') }}" 
                class="menu {{ isset($pagina) && $pagina == 'relatorio' ? 'active' : '' }}"
                <?= !$mostrar_menu
                    ? 
                        '
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="'.mensagem('menu_msg9').'"
                        '
                    :
                        ''
                ?>
                data-tooltip="Relatórios"
            >
                <i class="ph ph-scroll"></i>
                <span>{{mensagem('menu_msg9')}}</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>