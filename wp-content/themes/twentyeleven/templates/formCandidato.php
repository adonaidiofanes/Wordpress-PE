
<!-- jquery for equal height elements -->
<script type="text/javascript" src="<?php echo $PathTemplate; ?>js/formee.js"></script>
<script type="text/javascript" src="<?php echo $PathTemplate; ?>js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="<?php echo $PathTemplate; ?>js/scripts.js"></script>
<script type="text/javascript" src="<?php echo $PathTemplate; ?>js/jquery-ui-1.9.2.custom.js"></script>

<!-- css for structure -->
<link rel="stylesheet" href="<?php echo $PathTemplate; ?>css/formee-structure.css" type="text/css" media="screen" />
		
<!-- css for style -->
<link rel="stylesheet" href="<?php echo $PathTemplate; ?>css/formee-style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $PathTemplate; ?>css/redmond/jquery-ui-1.9.2.custom.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $PathTemplate; ?>css/styles.css" type="text/css" media="screen" />


<?php
    $current_user = wp_get_current_user();
    $_SESSION['current_user'] = $current_user;
    $_SESSION['PathTemplate'] = $PathTemplate;
    $_SESSION['Id'] = $current_user->ID;
    
    include_once $DirTemplate . 'Classes/Conexao.class.php';
    include_once $DirTemplate . 'Classes/Candidatos.class.php';
    include_once $DirTemplate . 'Classes/CandidatosDAO.class.php';
    
    $Candidato = new Candidato($current_user->ID);
    $Exp_Prof = new ExperienciaProfissional();
    
    // Verificando Sexo do Candidato
    $Masculino = ''; $Feminino = '';
    if( $Candidato->getSexo() == 'Masculino' ){
        $Masculino = 'checked';
    } else {
        $Feminino = 'checked';
    }
    
    // Verificar se o candidato - verificar nome e se a o pais atual existe
    if( ($Candidato->getNome() == null) && ( $Candidato->getPaisAtual() == null) ){
        // Candidato nao existe
        $chkCandidato = ' checked';
    } else {
        $chkCandidato = '';
    }
    
?>

<div class="formee grid-12-12 menuNavegacao">
    <input type="submit" title="Dados Pessoais" value="Dados Pessoais" id="formCandidatoDadosPessoais">
    <input type="submit" title="Experiência Profissional" value="Experiência Profissional" id="formCandidatoExperienciaProfissional">
    <input type="submit" title="Formação Acadêmica" value="Formação Acadêmica" id="formCandidatoFormacaoAcademica">
    
</div>

<form action="" id="formCandidato" method="POST" class="formee">
    
    <?php // @TODO: Esconder esses campos ?>
    <input type="text"     name="Id" id="Id" value="<?= $current_user->ID; ?>" disabled>
    <input type="text"     name="TemplateDirectory" id="TemplateDirectory" value="<?php echo $PathTemplate; ?>" disabled>
    <input type="Checkbox" name="TipoCadastro" id="TipoCadastro" <?=$chkCandidato;?>>Novo Cadastro
    <input type="text"     name="DirTemplate" id="DirTemplate" disabled value="<?=$DirTemplate;?>">

<!-- Dados Pessoais | formCandidatoDadosPessoais -->
    <fieldset class="formCandidatoDadosPessoais">
        
        <legend>Dados Pessoais</legend>
        
            <div class="grid-12-12">
                <label for="Nome">Nome Completo <em class="formee-req">*</em></label>
                <input type="text" value="<?= $Candidato->getNome(); ?>" name="Nome" id="Nome">
            </div>
        
        
            <div class="grid-4-12">
                <label for="Email">Email <em class="formee-req">*</em></label>
                <input type="text" value="<?= $current_user->user_email; ?>" name="Email" id="Email">
            </div>
        
            <div class="grid-4-12">
                <label for="DataNascimento">Data de Nascimento <em class="formee-req">*</em></label>
                <input type="text" value="<?= $Candidato->getDataNascimento(); ?>" name="DataNascimento" id="DataNascimento" class="data_ui">
            </div>
        
            <div class="grid-4-12">
                <label>Sexo <em class="formee-req">*</em></label>
                <ul class="formee-list">
                    <li><input type="radio" id="Masculino" value="Masculino" <?= $Masculino; ?> name="radioSexo"><label for="Masculino">Masculino</label></li>
                    <li><input type="radio" id="Feminino"  value="Feminino" <?= $Feminino; ?> name="radioSexo"><label for="Feminino">Feminino</label></li>
                </ul>
            </div>
        
            <div class="grid-5-12">
                <label for="EstadoCivil">Estado Civil <em class="formee-req">*</em></label>
                <select id="EstadoCivil" name="EstadoCivil">
                    <option value="1" <?php if($Candidato->getEstadoCivil() == 1 ){ echo 'selected'; } ?>>Solteiro(a)</option>
                    <option value="2" <?php if($Candidato->getEstadoCivil() == 2 ){ echo 'selected'; } ?>>Casado(a)</option>
                    <option value="3" <?php if($Candidato->getEstadoCivil() == 3 ){ echo 'selected'; } ?>>Viuvo(a)</option>
                    <option value="4" <?php if($Candidato->getEstadoCivil() == 4 ){ echo 'selected'; } ?>>Divorciado(a)</option>
                    <option value="5" <?php if($Candidato->getEstadoCivil() == 5 ){ echo 'selected'; } ?>>Separado(a)</option>
                </select>
            </div>
        
            <div class="grid-5-12">
                <label for="Nacionalidade">País de Nacionalidade <em class="formee-req">*</em></label>
                <?= $Candidato->listaPais($Candidato->getNacionalidade() ,'Nacionalidade'); ?>
            </div>
        
        
            <div class="grid-6-12">
                <label for="Pais">País Atual<em class="formee-req">*</em></label>
                <?= $Candidato->listaPais($Candidato->getPaisAtual(), 'PaisAtual'); ?>
            </div>
        
            <div class="grid-6-12">
                <label for="CEP">CEP <em class="formee-req">*</em></label>
                <input class="formee-medium" type="text" value="<?= $Candidato->getCEP(); ?>" name="CEP" id="CEP">
                <input type="submit" value="Buscar" title="Buscar">
            </div>
        
        
            <div class="grid-4-12">
                <label for="Endereco">Endereço <em class="formee-req">*</em></label>
                <input type="text" value="<?= $Candidato->getEndereco(); ?>" name="Endereco" id="Endereco">
            </div>
        
            <div class="grid-4-12">
                <label for="Complemento">Complemento </label>
                <input type="text" value="<?= $Candidato->getComplemento(); ?>" name="Complemento" id="Complemento">
            </div>

            <div class="grid-4-12">
                <label for="Bairro">Bairro <em class="formee-req">*</em></label>
                <input type="text" value="<?= $Candidato->getBairro(); ?>" name="Bairro" id="Bairro">
            </div>
        
        
            <div class="grid-6-12">
                <label for="Cidade">Cidade <em class="formee-req">*</em></label>
                <input type="text" value="<?= $Candidato->getCidade(); ?>" name="Cidade" id="Cidade">
            </div>
        
            <div class="grid-6-12">
                <label for="Estado">Estado <em class="formee-req">*</em></label>
                <?= $Candidato->listaEstado(); ?>
            </div>
        
            <div style="clear:both;"></div>
        
            <div class="grid-4-12">                
                <label for="Telefone">Telefone <em class="formee-req">*</em></label>
                <input type="text" value="<?= $Candidato->getTelRes(); ?>" name="Telefone" id="Telefone">
            </div>
        
            <div class="grid-4-12">
                <label for="TelCelular">Celular <em class="formee-req">*</em></label>
                <input type="text" value="<?= $Candidato->getTelCel(); ?>" name="TelCelular" id="TelCelular">
            </div>
        
            <div class="grid-4-12">
                <label for="TelRecados">Telefone para Recados</label>
                <input type="text" value="<?= $Candidato->getTelRec(); ?>" name="TelRecados" id="TelRecados">
            </div>
            
            <div class="grid-12-12">
                <a href="#" id="btnEnviarDadosPessoais" class="formee-button">> Salvar</a>
            </div>
        
    </fieldset>
    
    
    
    <!-- Experiencia Profissional | formCandidatoExperienciaProfissional -->
    
    <fieldset class="formCandidatoExperienciaProfissional">
        <legend>Experiência Profissional</legend>
        <small><a href="#" id="AddExperiencia">Adicionar nova experiência</a></small>
        <?php if($Candidato->getExperiencia_Profissional()){?>
        <div class="ui-widget">
        <table id="Experiencias" class="ui-widget ui-widget-content">
            <thead>
                <tr class="ui-widget-header">
                    <th>Empresa</th>
                    <th>Cargo</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                <?= $Exp_Prof->mostrarExperiencias($Candidato->getExperiencia_Profissional()); ?>
            </tbody>
            
        </table>
        </div>
        <?php } else { ?>
            <p>Cadastrar suas experiencias profissionais!</p>
        <?php } ?>
        
        <div id="Dialog" class="hide"></div>
            
        <!--
        <form id="Experiencia_Profissional" class="hide">
         <legend>Experiência Profissional</legend>

         <div class="grid-4-12">
             <label for="Empresa">Nome da Empresa <em class="formee-req">*</em></label>
             <input type="text" value="" name="Empresa" id="Empresa">
         </div>

         <div class="grid-4-12">
             <label for="Segmento">Segmento <em class="formee-req">*</em></label>
             <select id="Segmento" name="Segmento">
                 <option value="-1">Selecione uma opção</option><option value="1">(não classificado)</option><option value="3">Agricultura e Pecuária</option><option value="4">Alimentos</option><option value="5">Arquitetura</option><option value="6">Assistência Médica</option><option value="7">Associações</option><option value="8">Auditoria</option><option value="69">Automotivo</option><option value="9">Autopeças</option><option value="77">Bancos</option><option value="10">Bebidas</option><option value="71">Brindes</option><option value="11">Brinquedos</option><option value="12">Calçados e Couro</option><option value="80">Cama, mesa e banho</option><option value="13">Comércio Atacadista</option><option value="14">Comércio Exterior</option><option value="15">Comércio Varejista</option><option value="17">Construção Civil</option><option value="18">Consultoria</option><option value="19">Contabilidade</option><option value="78">Corretoras</option><option value="73">Distribuidores</option><option value="76">Eletrodomésticos</option><option value="21">Embalagens</option><option value="22">Energia</option><option value="23">Engenharia</option><option value="24">Ensino e Pesquisa</option><option value="25">Entretenimento – Cultura e Lazer</option><option value="26">Esporte</option><option value="27">Farmacêutico</option><option value="28">Ferramentas</option><option value="30">Finanças</option><option value="74">Franquias</option><option value="31">Fumo</option><option value="32">Governo</option><option value="33">Gráfica</option><option value="34">Higiene e Limpeza</option><option value="36">Hoteleiro</option><option value="38">Imobiliário</option><option value="37">Imprensa e Comunicação</option><option value="39">Indústria</option><option value="41">Internet</option><option value="42">Jurídico</option><option value="43">Madeira</option><option value="44">Máquinas e Equipamentos</option><option value="75">Material de construção</option><option value="72">Material de escritório</option><option value="20">Material eletrônico (componentes eletrônicos)</option><option value="45">Mecânica</option><option value="82">Meio Ambiente</option><option value="46">Metalúrgico, Siderúrgico </option><option value="47">Mineração</option><option value="48">Móveis e Decoração</option><option value="49">Não Metálicos</option><option value="50">Papel e Celulose</option><option value="52">Perfumaria e Cosméticos</option><option value="54">Petroquímica</option><option value="51">Plástico e Borracha</option><option value="53">Publicidade</option><option value="55">Química</option><option value="56">Recursos Humanos</option><option value="35">Saúde, Hospitalar e Laboratorial</option><option value="58">Seguradoras e Previdência Privada</option><option value="59">Serviços (outros)</option><option value="79">Serviços Públicos</option><option value="61">Tecnologia e Informática</option><option value="62">Telecomunicações</option><option value="81">Telemarketing / Call Center</option><option value="63">Terceiro setor / ONG</option><option value="64">Têxtil</option><option value="65">Transporte e Logística</option><option value="66">Turismo</option><option value="67">Utilidades Domésticas</option><option value="68">Vestuário</option>
             </select>
         </div>

         <div class="grid-4-12">
             <label for="DataEntrada">Data de Entrada <em class="formee-req">*</em></label>
             <input type="text" value="" name="DataEntrada" id="DataEntrada">
         </div>

         <div class="grid-4-12">
             <label for="DataSaida">Data de Saida <em class="formee-req">*</em></label>
             <input type="text" value="" name="DataSaida" id="DataSaida">
         </div>

         <div class="grid-4-12">
             <label for="Cargo">Cargo <em class="formee-req">*</em></label>
             <input type="text" value="" name="Cargo" id="UltimoCargo">
         </div>

         <div class="grid-12-12">
             <label for="Atividades">Atividades Desenvolvidas <em class="formee-req">*</em></label>
             <textarea id="Atividades" cols="" rows=""></textarea>
         </div>

         <div class="grid-12-12">
             <ul>
                 <li><a href="#">Adicionar Outra Experiência</a></li>
                 <li><a href="#">Remover Experiência</a></li>
             </ul>
         </div>
        </form>
            
        
        <legend>Experiência Profissional</legend>
        
        <div class="grid-4-12">
            <label for="Empresa">Nome da Empresa <em class="formee-req">*</em></label>
            <input type="text" value="" name="Empresa" id="Empresa">
        </div>
        
        <div class="grid-4-12">
            <label for="Segmento">Segmento <em class="formee-req">*</em></label>
            <select id="Segmento" name="Segmento">
                <option value="-1">Selecione uma opção</option><option value="1">(não classificado)</option><option value="3">Agricultura e Pecuária</option><option value="4">Alimentos</option><option value="5">Arquitetura</option><option value="6">Assistência Médica</option><option value="7">Associações</option><option value="8">Auditoria</option><option value="69">Automotivo</option><option value="9">Autopeças</option><option value="77">Bancos</option><option value="10">Bebidas</option><option value="71">Brindes</option><option value="11">Brinquedos</option><option value="12">Calçados e Couro</option><option value="80">Cama, mesa e banho</option><option value="13">Comércio Atacadista</option><option value="14">Comércio Exterior</option><option value="15">Comércio Varejista</option><option value="17">Construção Civil</option><option value="18">Consultoria</option><option value="19">Contabilidade</option><option value="78">Corretoras</option><option value="73">Distribuidores</option><option value="76">Eletrodomésticos</option><option value="21">Embalagens</option><option value="22">Energia</option><option value="23">Engenharia</option><option value="24">Ensino e Pesquisa</option><option value="25">Entretenimento – Cultura e Lazer</option><option value="26">Esporte</option><option value="27">Farmacêutico</option><option value="28">Ferramentas</option><option value="30">Finanças</option><option value="74">Franquias</option><option value="31">Fumo</option><option value="32">Governo</option><option value="33">Gráfica</option><option value="34">Higiene e Limpeza</option><option value="36">Hoteleiro</option><option value="38">Imobiliário</option><option value="37">Imprensa e Comunicação</option><option value="39">Indústria</option><option value="41">Internet</option><option value="42">Jurídico</option><option value="43">Madeira</option><option value="44">Máquinas e Equipamentos</option><option value="75">Material de construção</option><option value="72">Material de escritório</option><option value="20">Material eletrônico (componentes eletrônicos)</option><option value="45">Mecânica</option><option value="82">Meio Ambiente</option><option value="46">Metalúrgico, Siderúrgico </option><option value="47">Mineração</option><option value="48">Móveis e Decoração</option><option value="49">Não Metálicos</option><option value="50">Papel e Celulose</option><option value="52">Perfumaria e Cosméticos</option><option value="54">Petroquímica</option><option value="51">Plástico e Borracha</option><option value="53">Publicidade</option><option value="55">Química</option><option value="56">Recursos Humanos</option><option value="35">Saúde, Hospitalar e Laboratorial</option><option value="58">Seguradoras e Previdência Privada</option><option value="59">Serviços (outros)</option><option value="79">Serviços Públicos</option><option value="61">Tecnologia e Informática</option><option value="62">Telecomunicações</option><option value="81">Telemarketing / Call Center</option><option value="63">Terceiro setor / ONG</option><option value="64">Têxtil</option><option value="65">Transporte e Logística</option><option value="66">Turismo</option><option value="67">Utilidades Domésticas</option><option value="68">Vestuário</option>
            </select>
        </div>
        
        <div class="grid-4-12">
            <label for="DataEntrada">Data de Entrada <em class="formee-req">*</em></label>
            <input type="text" value="" name="DataEntrada" id="DataEntrada">
        </div>
        
        <div class="grid-4-12">
            <label for="DataSaida">Data de Saida <em class="formee-req">*</em></label>
            <input type="text" value="" name="DataSaida" id="DataSaida">
        </div>
        
        <div class="grid-4-12">
            <label for="Cargo">Cargo <em class="formee-req">*</em></label>
            <input type="text" value="" name="Cargo" id="UltimoCargo">
        </div>
        
        <div class="grid-12-12">
            <label for="Atividades">Atividades Desenvolvidas <em class="formee-req">*</em></label>
            <textarea id="Atividades" cols="" rows=""></textarea>
        </div>
        
        <div class="grid-12-12">
            <ul>
                <li><a href="#">Adicionar Outra Experiência</a></li>
                <li><a href="#">Remover Experiência</a></li>
            </ul>
        </div> -->
        
        
    </fieldset>
    
    <!-- Formacao Academica | formCandidatoFormacaoAcademica -->
    
    <fieldset class="formCandidatoFormacaoAcademica">
        
        <legend>Formação Acadêmica</legend>
        
        <div class="grid-6-12">
            <label for="TipoCurso">Tipo do Curso <em class="formee-req">*</em></label>
            <select id="TipoCurso">
                <option value="-1">Selecione uma opção</option><option value="10">Formação escolar fundamental (1o grau) e média (2o grau)</option><option value="20">Curso técnico – Médio (2o grau)</option><option value="30">Graduação</option><option value="40">Pós-Graduação – Especialização</option><option value="50">Pós-Graduação – MBA</option><option value="60">Pós-Graduação – Mestrado</option><option value="70">Pós-Graduação – Doutorado</option><option value="80">Cursos Complementares</option>
            </select>
        </div>        
        
        <div class="grid-6-12">
            <label for="Instituicao">Nome da Instituição <em class="formee-req">*</em></label>
            <input type="text" value="" name="Instituicao" id="Instituicao">
        </div>
        
        <div class="grid-12-12">
            <label for="Curso">Nome do Curso <em class="formee-req">*</em></label>
            <input type="text" value="" name="Curso" id="Curso">
        </div>
        
        <div class="grid-6-12">
            <label>Situação <em class="formee-req">*</em></label>
            <ul class="formee-list">
                <li><input type="radio" id="Concluido" name="situacao"><label for="Concluido">Concluído</label></li>
                <li><input type="radio" id="Cursando"  name="situacao"><label for="Cursando">Cursando</label></li>
                <li><input type="radio" id="Interrompido"  name="situacao"><label for="Interrompido">Interrompido</label></li>
            </ul>    
        </div>
        
        <div class="grid-6-12">
            <label for="Curso">Mês/Ano de conclusão <em class="formee-req">*</em></label>
            <input type="text" value="" name="AnoConclusao" id="AnoConclusao">
        </div>
        
        <div class="grid-12-12">
            <ul>
                <li><a href="#">Adicionar Outra Formação</a></li>
                <li><a href="#">Remover Formação</a></li>
            </ul>
        </div>
        
    </fieldset>
        
</form>

