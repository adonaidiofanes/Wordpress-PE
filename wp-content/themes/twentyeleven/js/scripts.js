$(document).ready(function() {
    
    var PATH = "http://127.0.0.1/wordpress/wp-content/themes/twentyeleven/";
    
    /*----------------------------------------------------------------------------------*/
    /* RESPONSAVEL PELAS REQUISICOES POST COM OVERLAY */
    /*----------------------------------------------------------------------------------*/

    var service = function(data, action, tipo, callback){
        $.ajax({
            type : tipo,
            url  : $('#TemplateDirectory').val() + 'Controllers/' + action + '.controller.php',
            beforeSend: criarOverlay,
            data : data,
            dataType : 'json',
            success: function(dados){
               if(dados.sucesso){
                  removerOverlay();
                  callback(dados);

               }else{
                   removerOverlay();
                   alert(dados.erro);   
               }
            },
            error : function(){
                removerOverlay();
                alert("Desculpe não foi possível efetuar a solicitação.\nTente novamente mais tarde ou entre em contato através do formulário de contato.");
            }

        });
    };
    
    /*----------------------------------------------------------------------------------*/
    /* CRIAR OVERLAY DE LOADING */
    /*----------------------------------------------------------------------------------*/
    var criarOverlay = function(){
        var $div = $('<div />');
        
        $div.clone().css({
            'width' : $(window).width() + 'px',
            'height' : $(window).height() + 'px'
        })
        .addClass('overlay')
        .appendTo('body');
        
        return criarLoading();
    };
    
    var removerOverlay = function(){
        $('.overlay, .loading, .boxMsg').remove();
    };
    
    var criarLoading = function(){
        var $div = $('<div />');
        
        $div.addClass('loading border-radius box-shadow')
        .html('<img src="'+ PATH +'images/loader.gif" alt="" /><p>carregando...</p>')
        .appendTo('body');
        
        $div.css({
            left : ($(window).width() / 2) - ($div.width() / 2) + 'px',
            top : ($(window).height() / 2) - ($div.height() / 2) + 'px'
        });
        
    };
    
    /*----------------------------------------------------------------------------------*/
    /* CONTROLE DO OVERLAY DE MENSAGENS */
    /*----------------------------------------------------------------------------------*/
    var overlayMensagem = function($msg){
        var $div = $('<div />');
        
        $div.clone().css({
            'width' : $(window).width() + 'px',
            'height' : $(window).height() + 'px'
        })
        .addClass('overlay')
        .appendTo('body');
        
        return boxMsg($msg);
    };
    
    var boxMsg = function($msg){
        var $div = $('<div />');
        
        $div.addClass('boxMsg border-radius box-shadow')
        .html($msg)
        .appendTo('body');
        
        $div.css({
            left : ($(window).width() / 2) - ($div.width() / 2) + 'px',
            top : ($(window).height() / 2) - ($div.height() / 2) + 'px'
        });
        
    };
    
    $(".overlay, .boxMsg").live('click', function(e){ e.preventDefault(); removerOverlay(); });

    /*----------------------------------------------------------------------------------*/
    /* RESPONSAVEL PELAS REQUISICOES DO CADASTRO DE CANDIDATO */
    /*----------------------------------------------------------------------------------*/
    $('#btnEnviarDadosPessoais').live('click', function(e){
            e.preventDefault();
            
            if( $("#TipoCadastro").is(":checked") ){
                var Metodo = 'NovoCadastro';
            } else {
                var Metodo = 'AtualizarCadastro';
            }

            var data = $("form").serializeArray();
            /*mock*/data.push({ name : "CarregarDadosCandidato", value: "1" });
            data.push({ name : "DirTemplate", value : $("#DirTemplate").val() });
            data.push({ name : "Id", value : $("#Id").val() });
            data.push({ name : "TemplateDirectory", value : $("#TemplateDirectory").val() });
            data.push({ name : "TipoCadastro", value : Metodo });
            
            service(data, 'Candidatos', 'POST', CadastroDadosPessoais);
            
    });
    
    var CadastroDadosPessoais = function(data){
        if(data.sucesso){
            // overlay com mensagem
            overlayMensagem(data.sucesso);
            // caso seja cadastrado com sucesso, desmarcar o checkbox de novo cadastro
            $("#TipoCadastro").attr('checked', false);
        }
    };

    /*----------------------------------------------------------------------------------*/
    /* CONTROLE DO MENU DE NAVEGAÇÃO */
    /*----------------------------------------------------------------------------------*/
    $(".menuNavegacao input").live('click', function(e){
        e.preventDefault();
        var objeto = $(this).attr('id');
        $("#main").find('fieldset').hide();
        $("."+objeto).show();
    });
    
    /*----------------------------------------------------------------------------------*/
    /* CONTROLE EXPERIENCIA PROFISSIONAL */
    /*----------------------------------------------------------------------------------*/
    $("table#Experiencias a").live('click', function(e){
        e.preventDefault();
        
        var data = new Array();
        
        var Id = $(this).attr('id');
        var Acao = $(this).attr('title');
        
        data.push({ name : "IdCandidato", value : $("#Id").val() });
        data.push({ name : "Id", value : Id });
        data.push({ name : "Acao", value : Acao });
        data.push({ name : "DirTemplate", value : $("#DirTemplate").val() });
        
        if( Acao == 'Editar' ){
            service(data, 'ExperienciaProfissional', 'GET', ExperienciasEditar);
        }
        
        if( Acao == 'Excluir' ){
            service(data, 'ExperienciaProfissional', 'GET', ExperienciasExcluir);
        }
        
    });

    /*----------------------------------------------------------------------------------*/
    /* EXPERIENCIA PROFISSIONAL - CONTROLE EDITAR */
    /*----------------------------------------------------------------------------------*/
    var $formEditarExperiencia = '<div id="dialog-modal" title="@Titulo">' +
                                    "<form>" +
                                        "<fieldset>" +
                                            "<input type='text' name='IdCandidato' value='@IdCandidato' disabled>" +
                                            "<input type='text' name='IdExperiencia' value='@IdExperiencia' disabled>" +
                                        
                                            "<label for='Nome_Empresa'>Nome da Empresa</label>" +
                                            "<input type='text' name='Nome_Empresa' id='Nome_Empresa' value='@Empresa'>" +

                                            "<label for='Segmentos'>Segmento da Empresa</label>" +
                                            "@Segmentos" +
                                            
                                            "<label for='Data_Entrada'>Data de Entrada</label>" +
                                            "<input type='text' name='Data_Entrada' id='Data_Entrada' value='@Data_Entrada'>" +
                                            
                                            "<label for='Data_Saida'>Data de Saída</label>" +
                                            "<input type='text' name='Data_Saida' id='Data_Saida' value='@Data_Saida'>" +
                                            
                                            "<label for='Cargo'>Cargo</label>" +
                                            "<input type='text' name='Cargo' id='Cargo' value='@Cargo'>" +
                                            
                                            "<label for='Atividades_Desenvolvidas'>Atividades Desenvolvidas</label>" +
                                            "<textarea rows='3' cols='20' name='Atividades_Desenvolvidas' id='Atividades_Desenvolvidas'>@Atividades_Desenvolvidas" +
                                            "</textarea>" +
                                            
                                            "<label>Emprego Atual</label>" +
                                            "<label for='Sim'><input type='radio' id='Sim' name='Emprego_Atual' id='' @Sim>Sim</label>" +
                                            "<label for='Nao'><input type='radio' id='Nao' name='Emprego_Atual' id='' @Nao>Não</label>" +
              
                                            "<input type='submit' value='Salvar'>" +
                                        "</fieldset>" +
                                    "</form>";
                                "</div>";
    
    var ExperienciasEditar = function(d){
        
        // Gravar array de retorno da requisicao na variavel obj
        var $obj = d.sucesso[0];
        var $Segmentos = d.sucesso[1].Segmentos;
        var Sim, Nao = '';
        
        // Verificar se é o emprego atual
        if( $obj.Emprego_Atual == 1 ){ Sim = 'checked'; } else { Nao = 'checked'; }
        
        // Remover dialog caso exista
        $( "#dialog-modal" ).remove();
        
        // Popular informações do formulario para edição
        var $tpl = $formEditarExperiencia.replace("@Empresa", $obj.Nome_Empresa );
            $tpl = $tpl.replace("@Titulo",  $obj.Nome_Empresa );
            $tpl = $tpl.replace("@Data_Entrada",  $obj.Data_Entrada );
            $tpl = $tpl.replace("@Data_Saida",  $obj.Data_Saida );
            $tpl = $tpl.replace("@Cargo",  $obj.Cargo );
            $tpl = $tpl.replace("@Atividades_Desenvolvidas",  $obj.Atividades_Desenvolvidas );
            $tpl = $tpl.replace("@IdCandidato",  $obj.IdCandidato );
            $tpl = $tpl.replace("@IdExperiencia",  $obj.Id );
            $tpl = $tpl.replace("@Segmentos",  $Segmentos );
            $tpl = $tpl.replace("@Sim",  Sim );
            $tpl = $tpl.replace("@Nao",  Nao );

        // Inserir informações no dialog-modal
        $('body').append($tpl);
        $( "#dialog-modal" ).dialog({
          height: 400,
          width: 400,
          modal: true
        });
    }; // Fim > ExperienciasEditar
    
    /*----------------------------------------------------------------------------------*/
    /* EXPERIENCIA PROFISSIONAL - CONTROLE EXCLUIR */
    /*----------------------------------------------------------------------------------*/
    var ExperienciasExcluir = function(d){
        
        if(d.sucesso){
            overlayMensagem(d.sucesso);
            // Remover linha excluida
            $('.linha'+d.IdApagar).remove();
        } else {
            // Exibir mensagem de erro no overlay
            alert('Erro');
        }
    };
    
    /*----------------------------------------------------------------------------------*/
    /* EXPERIENCIA PROFISSIONAL - CONTROLE ADICIONAR */
    /*----------------------------------------------------------------------------------*/
    $("#AddExperiencia").live('click', function(e){
        e.preventDefault();
        // Remover dialog caso exista
        $( "#dialog-modal" ).remove();
        // Criar array que vai ser postado para o controller
        var data = new Array();
        // Gravar dado do candidato
        var Id = $(this).attr('id');
        
        data.push({ name : "IdCandidato", value : $("#Id").val() });
        data.push({ name : "Acao", value : 'ExperienciasFormMontarInserir' });
        data.push({ name : "DirTemplate", value : $("#DirTemplate").val() });
        
        // Regatar dados de segmentos e montar o select
        service(data, 'ExperienciaProfissional', 'POST', ExperienciasFormMontarInserir);
        
    });
    $("#btnInserirExperiencia").live('click', function(e){
        e.preventDefault();
        
        var data = $("#formAddExperiencia").serializeArray();
            data.push({ name : "IdCandidato", value : $("#Id").val() });
            data.push({ name : "Acao", value : 'InserirExperiencia' });
        
        // TODO : Fazer ir na $DAO e salvar, retornar mensagem para usuario (sucesso ou erro).
        service(data, 'ExperienciaProfissional', 'POST', ExperienciaInserir);
        // ':IdCandidato, :Nome_Empresa, :IdSegmento, :Data_Entrada, :Data_Saida, :Cargo, :Atividades_Desenvolvidas, :Emprego_Atual, NOW(), NOW())';
    });
    
    var ExperienciaInserir = function(d){
        console.log('Voltei do inserir');
        console.log(d);
    }
    
    // TPL > Form de inserção de experiencia
    var ExperienciasFormMontarInserir = function(d){
        
        // Gravar array de retorno da requisicao na variavel obj
        var $obj = d.sucesso;

        // Popular informações do formulario para inserção
        var $tpl = $formAdicionarExperiencia.replace("@Segmentos", $obj.Segmento );
            $tpl = $tpl.replace("@IdCandidato",  $obj.IdCandidato );

        // Inserir informações no dialog-modal
        $('body').append($tpl);
        $( "#dialog-modal" ).dialog({
          height: 400,
          width: 400,
          modal: true
        });
    }; // Fim > ExperienciasFormMontarInserir
    
    // TPL > INSERIR EXPERIENCIA
    var $formAdicionarExperiencia = '<div id="dialog-modal" title="Adicionar Experiência">' +
                                    "<form id='formAddExperiencia'>" +
                                        "<fieldset>" +
                                            "<input type='text' name='IdCandidato' value='@IdCandidato' disabled>" +
                                        
                                            "<label for='Nome_Empresa'>Nome da Empresa</label>" +
                                            "<input type='text' name='Nome_Empresa' id='Nome_Empresa' value=''>" +

                                            "<label for='Segmentos'>Segmento da Empresa</label>" +
                                            "@Segmentos" +
                                            
                                            "<label for='Data_Entrada'>Data de Entrada</label>" +
                                            "<input type='text' name='Data_Entrada' id='Data_Entrada' value=''>" +
                                            
                                            "<label for='Data_Saida'>Data de Saída</label>" +
                                            "<input type='text' name='Data_Saida' id='Data_Saida' value=''>" +
                                            
                                            "<label for='Cargo'>Cargo</label>" +
                                            "<input type='text' name='Cargo' id='Cargo' value=''>" +
                                            
                                            "<label for='Atividades_Desenvolvidas'>Atividades Desenvolvidas</label>" +
                                            "<textarea rows='3' cols='20' name='Atividades_Desenvolvidas' id='Atividades_Desenvolvidas'>" +
                                            "</textarea>" +
                                            
                                            "<label>Emprego Atual</label>" +
                                            "<label for='Sim'><input type='radio' id='Sim' name='Emprego_Atual' id=''>Sim</label>" +
                                            "<label for='Nao'><input type='radio' id='Nao' name='Emprego_Atual' id=''>Não</label>" +
              
                                            "<input id='btnInserirExperiencia' type='submit' value='Salvar'>" +
                                        "</fieldset>" +
                                    "</form>";
                                "</div>";
    
});
