
<!-- jquery for equal height elements -->
<script type="text/javascript" src="<?php echo $PathTemplate; ?>js/formee.js"></script>
<script type="text/javascript" src="<?php echo $PathTemplate; ?>js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="<?php echo $PathTemplate; ?>js/scripts.js"></script>

<!-- css for structure -->
<link rel="stylesheet" href="<?php echo $PathTemplate; ?>css/formee-structure.css" type="text/css" media="screen" />
		
<!-- css for style -->
<link rel="stylesheet" href="<?php echo $PathTemplate; ?>css/formee-style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $PathTemplate; ?>css/styles.css" type="text/css" media="screen" />


<?php
    $current_user = wp_get_current_user();
    
    include_once $DirTemplate . 'Classes/Conexao.class.php';
    include_once $DirTemplate . 'Classes/Candidatos.class.php';
    include_once $DirTemplate . 'Classes/CandidatosDAO.class.php';
    
    $Candidato = new Candidato($current_user->ID);
    //$Candidato->setId($current_user->ID);
    /*$DAO = new CandidatosDAO();
    
    $DAO->selectById($current_user->ID);
    
    echo '<pre>';
    print_r($current_user);
    echo '</pre>';*/
    
    echo "oii" . $Candidato->getNome() . ' --> ' . $Candidato->getDataNascimento();
    
?>

<form action="" id="formCandidato" method="POST" class="formee">
    
    <input type="text" name="idCandidato" id="idCandidato" value="<?= $current_user->ID; ?>" disabled>
    <input type="text" name="TemplateDirectory" id="TemplateDirectory" value="<?php echo $PathTemplate; ?>" disabled>
    
    <fieldset class="formCandidatoDadosPessoais">
        
        <legend>Dados Pessoais</legend>
        
            <div class="grid-12-12">
                <label for="NomeCompleto">Nome Completo <em class="formee-req">*</em></label>
                <input type="text" value="" name="NomeCompleto" id="NomeCompleto">
            </div>
        
        
            <div class="grid-4-12">
                <label for="Email">Email <em class="formee-req">*</em></label>
                <input type="text" value="" name="Email" id="Email">
            </div>
        
            <div class="grid-4-12">
                <label for="DataNascimento">Data de Nascimento <em class="formee-req">*</em></label>
                <input type="text" value="" name="DataNascimento" id="DataNascimento" class="data_ui">
            </div>
        
            <div class="grid-4-12">
                <label>Sexo <em class="formee-req">*</em></label>
                <ul class="formee-list">
                    <li><input type="radio" id="Masculino" value="Masculino" name="radioSexo"><label for="Masculino">Masculino</label></li>
                    <li><input type="radio" id="Feminino"  value="Feminino" name="radioSexo"><label for="Feminino">Feminino</label></li>
                </ul>    
            </div>
        
            <div class="grid-5-12">
                <label for="EstadoCivil">Estado Civil <em class="formee-req">*</em></label>
                <select id="EstadoCivil">
                    <option value="Solteiro(a)">Solteiro(a)</option>
                    <option value="Casado(a)">Casado(a)</option>
                    <option value="Viuvo(a)">Viuvo(a)</option>
                    <option value="Divorciado(a)">Divorciado(a)</option>
                    <option value="Separado(a)">Separado(a)</option>
                </select>
            </div>
        
            <div class="grid-5-12">
                <label for="Nacionalidade">País de Nacionalidade <em class="formee-req">*</em></label>
                <select id="Nacionalidade">
                    <option value="1">Brasil</option><option value="2">Afeganistão</option><option value="3">África do Sul</option><option value="4">Albânia</option><option value="5">Alemanha</option><option value="6">Andorra</option><option value="7">Angola</option><option value="8">Anguilla</option><option value="9">Antártica</option><option value="10">Antígua e Barbuda</option><option value="11">Antilhas Holandesas</option><option value="12">Arábia Saudita</option><option value="13">Argélia</option><option value="14">Argentina</option><option value="15">Armênia</option><option value="16">Aruba</option><option value="17">Austrália</option><option value="18">Áustria</option><option value="19">Azerbaijão</option><option value="20">Bahamas</option><option value="21">Bangladesh</option><option value="22">Barbados</option><option value="23">Barein</option><option value="24">Belarus</option><option value="25">Bélgica</option><option value="26">Belize</option><option value="27">Benin</option><option value="28">Bermuda</option><option value="29">Bolívia</option><option value="30">Bósnia e Herzegovina</option><option value="31">Botswana</option><option value="32">Brasil</option><option value="33">Brunei Darussalém</option><option value="34">Bulgária</option><option value="35">Burkina Fasso</option><option value="36">Burundi</option><option value="37">Butão</option><option value="38">Cabo Verde</option><option value="39">Camarões</option><option value="40">Camboja</option><option value="41">Canadá</option><option value="42">Catar</option><option value="43">Cazaquistão</option><option value="44">Chade</option><option value="45">Chile</option><option value="46">China</option><option value="47">Chipre</option><option value="48">Cidade do Vaticano</option><option value="49">Cingapura</option><option value="50">Colômbia</option><option value="51">Congo (Brazzaville)</option><option value="52">Congo (Kinshasa)</option><option value="53">Coréia do Norte</option><option value="54">Coréia do Sul</option><option value="55">Costa do Marfim</option><option value="56">Costa Rica</option><option value="57">Croácia</option><option value="58">Cuba</option><option value="59">Dinamarca</option><option value="60">Djibuti</option><option value="61">Dominica</option><option value="62">Egito</option><option value="63">El Salvador</option><option value="64">Emirados Árabes Unidos</option><option value="65">Equador</option><option value="66">Eritréia</option><option value="67">Eslováquia</option><option value="68">Eslovênia</option><option value="69">Espanha</option><option value="70">Estados Unidos</option><option value="71">Estônia</option><option value="72">Etiópia</option><option value="73">Fiji</option><option value="74">Filipinas</option><option value="75">Finlândia</option><option value="76">França</option><option value="77">Gabão</option><option value="78">Gâmbia</option><option value="79">Gana</option><option value="80">Geórgia</option><option value="81">Geórgia do Sul e Ilhas Sandwich</option><option value="82">Gibraltar</option><option value="83">Granada</option><option value="84">Grécia</option><option value="85">Groelândia</option><option value="86">Guadalupe</option><option value="87">Guatemala</option><option value="88">Guiana</option><option value="89">Guiana Francesa</option><option value="90">Guiné</option><option value="91">Guiné Equatorial</option><option value="92">Guiné-Bissau</option><option value="93">Haiti</option><option value="94">Holanda</option><option value="95">Honduras</option><option value="96">Hong Kong</option><option value="97">Hungria</option><option value="98">Iêmen</option><option value="99">Ilha Bouvet</option><option value="100">Ilha Norfolk</option><option value="101">Ilha Reunião</option><option value="102">Ilhas Cayman</option><option value="103">Ilhas Christmas</option><option value="104">Ilhas Cocos</option><option value="105">Ilhas Comores</option><option value="106">Ilhas Cook</option><option value="107">Ilhas Falkland (Malvinas)</option><option value="108">Ilhas Feroé</option><option value="109">Ilhas Heard e Mcdonald</option><option value="110">Ilhas Salomão</option><option value="111">Ilhas Svalbard e Jan Mayen</option><option value="112">Ilhas Turks e Caicos</option><option value="113">Ilhas Virgens Britânicas</option><option value="114">Ilhas Wallis e Futuna</option><option value="115">Índia</option><option value="116">Indonésia</option><option value="117">Irã</option><option value="118">Iraque</option><option value="119">Irlanda</option><option value="120">Islândia</option><option value="121">Israel</option><option value="122">Itália</option><option value="123">Jamaica</option><option value="124">Japão</option><option value="125">Jordânia</option><option value="126">Kiribati</option><option value="127">Kuwait</option><option value="128">Laos</option><option value="129">Lesoto</option><option value="130">Letônia</option><option value="131">Líbano</option><option value="132">Libéria</option><option value="133">Líbia</option><option value="134">Liechtenstein</option><option value="135">Lituânia</option><option value="136">Luxemburgo</option><option value="137">Macau</option><option value="138">Macedônia</option><option value="139">Madagascar</option><option value="140">Malásia</option><option value="141">Malavi</option><option value="142">Maldivas</option><option value="143">Mali</option><option value="144">Malta</option><option value="145">Marrocos</option><option value="146">Martinica</option><option value="147">Maurício</option><option value="148">Mauritânia</option><option value="149">Mayotte</option><option value="150">México</option><option value="151">Moçambique</option><option value="152">Moldávia</option><option value="153">Mônaco</option><option value="154">Mongólia</option><option value="155">Montenegro</option><option value="156">Montserrat</option><option value="157">Myanma</option><option value="158">Namíbia</option><option value="159">Nauru</option><option value="160">Nepal</option><option value="161">Nicarágua</option><option value="162">Níger</option><option value="163">Nigéria</option><option value="164">Niue</option><option value="165">Noruega</option><option value="166">Nova Caledônia</option><option value="167">Nova Zelândia</option><option value="168">Omã</option><option value="169">Panamá</option><option value="170">Papua-Nova Guiné</option><option value="171">Paquistão</option><option value="172">Paraguai</option><option value="173">Peru</option><option value="174">Pitcairn</option><option value="175">Polinésia Francesa</option><option value="176">Polônia</option><option value="177">Portugal</option><option value="178">Quênia</option><option value="179">Quirguistão</option><option value="180">Reino Unido</option><option value="181">República Centro-Africana</option><option value="182">República Dominicana</option><option value="183">República Tcheca</option><option value="184">Romênia</option><option value="185">Ruanda</option><option value="186">Russia</option><option value="187">Saara Ocidental</option><option value="188">Saint Kitts e Nevis</option><option value="189">Saint Pierre e Miquelon</option><option value="190">Samoa</option><option value="191">Santa Helena</option><option value="192">Santa Lúcia</option><option value="193">São Marino</option><option value="194">São Tomé e Príncipe</option><option value="195">São Vicente e Granadinas</option><option value="196">Senegal</option><option value="197">Serra Leoa</option><option value="198">Sérvia</option><option value="199">Seychelles</option><option value="200">Síria</option><option value="201">Somália</option><option value="202">Sri Lanka</option><option value="203">Suazilândia</option><option value="204">Sudão</option><option value="205">Suécia</option><option value="206">Suíça</option><option value="207">Suriname</option><option value="208">Tadjiquistão</option><option value="209">Tailândia</option><option value="210">Taiwan</option><option value="211">Tanzânia</option><option value="212">Territórios Britânicos do Oceano Índico</option><option value="213">Territórios Franceses do Sul</option><option value="214">Timor Oriental</option><option value="215">Togo</option><option value="216">Tokelau</option><option value="217">Tonga</option><option value="218">Trinidad e Tobago</option><option value="219">Tunísia</option><option value="220">Turcomenistão</option><option value="221">Turquia</option><option value="222">Tuvalu</option><option value="223">Ucrânia</option><option value="224">Uganda</option><option value="225">Uruguai</option><option value="226">Uzbequistão</option><option value="227">Vanuatu</option><option value="228">Venezuela</option><option value="229">Vietnã</option><option value="230">Zâmbia</option><option value="231">Zimbabwedd</option>
                </select>
            </div>
        
        
            <div class="grid-6-12">
                <label for="Pais">País Atual<em class="formee-req">*</em></label>
                <select id="Pais">
                    <option value="1">Brasil</option><option value="2">Afeganistão</option><option value="3">África do Sul</option><option value="4">Albânia</option><option value="5">Alemanha</option><option value="6">Andorra</option><option value="7">Angola</option><option value="8">Anguilla</option><option value="9">Antártica</option><option value="10">Antígua e Barbuda</option><option value="11">Antilhas Holandesas</option><option value="12">Arábia Saudita</option><option value="13">Argélia</option><option value="14">Argentina</option><option value="15">Armênia</option><option value="16">Aruba</option><option value="17">Austrália</option><option value="18">Áustria</option><option value="19">Azerbaijão</option><option value="20">Bahamas</option><option value="21">Bangladesh</option><option value="22">Barbados</option><option value="23">Barein</option><option value="24">Belarus</option><option value="25">Bélgica</option><option value="26">Belize</option><option value="27">Benin</option><option value="28">Bermuda</option><option value="29">Bolívia</option><option value="30">Bósnia e Herzegovina</option><option value="31">Botswana</option><option value="32">Brasil</option><option value="33">Brunei Darussalém</option><option value="34">Bulgária</option><option value="35">Burkina Fasso</option><option value="36">Burundi</option><option value="37">Butão</option><option value="38">Cabo Verde</option><option value="39">Camarões</option><option value="40">Camboja</option><option value="41">Canadá</option><option value="42">Catar</option><option value="43">Cazaquistão</option><option value="44">Chade</option><option value="45">Chile</option><option value="46">China</option><option value="47">Chipre</option><option value="48">Cidade do Vaticano</option><option value="49">Cingapura</option><option value="50">Colômbia</option><option value="51">Congo (Brazzaville)</option><option value="52">Congo (Kinshasa)</option><option value="53">Coréia do Norte</option><option value="54">Coréia do Sul</option><option value="55">Costa do Marfim</option><option value="56">Costa Rica</option><option value="57">Croácia</option><option value="58">Cuba</option><option value="59">Dinamarca</option><option value="60">Djibuti</option><option value="61">Dominica</option><option value="62">Egito</option><option value="63">El Salvador</option><option value="64">Emirados Árabes Unidos</option><option value="65">Equador</option><option value="66">Eritréia</option><option value="67">Eslováquia</option><option value="68">Eslovênia</option><option value="69">Espanha</option><option value="70">Estados Unidos</option><option value="71">Estônia</option><option value="72">Etiópia</option><option value="73">Fiji</option><option value="74">Filipinas</option><option value="75">Finlândia</option><option value="76">França</option><option value="77">Gabão</option><option value="78">Gâmbia</option><option value="79">Gana</option><option value="80">Geórgia</option><option value="81">Geórgia do Sul e Ilhas Sandwich</option><option value="82">Gibraltar</option><option value="83">Granada</option><option value="84">Grécia</option><option value="85">Groelândia</option><option value="86">Guadalupe</option><option value="87">Guatemala</option><option value="88">Guiana</option><option value="89">Guiana Francesa</option><option value="90">Guiné</option><option value="91">Guiné Equatorial</option><option value="92">Guiné-Bissau</option><option value="93">Haiti</option><option value="94">Holanda</option><option value="95">Honduras</option><option value="96">Hong Kong</option><option value="97">Hungria</option><option value="98">Iêmen</option><option value="99">Ilha Bouvet</option><option value="100">Ilha Norfolk</option><option value="101">Ilha Reunião</option><option value="102">Ilhas Cayman</option><option value="103">Ilhas Christmas</option><option value="104">Ilhas Cocos</option><option value="105">Ilhas Comores</option><option value="106">Ilhas Cook</option><option value="107">Ilhas Falkland (Malvinas)</option><option value="108">Ilhas Feroé</option><option value="109">Ilhas Heard e Mcdonald</option><option value="110">Ilhas Salomão</option><option value="111">Ilhas Svalbard e Jan Mayen</option><option value="112">Ilhas Turks e Caicos</option><option value="113">Ilhas Virgens Britânicas</option><option value="114">Ilhas Wallis e Futuna</option><option value="115">Índia</option><option value="116">Indonésia</option><option value="117">Irã</option><option value="118">Iraque</option><option value="119">Irlanda</option><option value="120">Islândia</option><option value="121">Israel</option><option value="122">Itália</option><option value="123">Jamaica</option><option value="124">Japão</option><option value="125">Jordânia</option><option value="126">Kiribati</option><option value="127">Kuwait</option><option value="128">Laos</option><option value="129">Lesoto</option><option value="130">Letônia</option><option value="131">Líbano</option><option value="132">Libéria</option><option value="133">Líbia</option><option value="134">Liechtenstein</option><option value="135">Lituânia</option><option value="136">Luxemburgo</option><option value="137">Macau</option><option value="138">Macedônia</option><option value="139">Madagascar</option><option value="140">Malásia</option><option value="141">Malavi</option><option value="142">Maldivas</option><option value="143">Mali</option><option value="144">Malta</option><option value="145">Marrocos</option><option value="146">Martinica</option><option value="147">Maurício</option><option value="148">Mauritânia</option><option value="149">Mayotte</option><option value="150">México</option><option value="151">Moçambique</option><option value="152">Moldávia</option><option value="153">Mônaco</option><option value="154">Mongólia</option><option value="155">Montenegro</option><option value="156">Montserrat</option><option value="157">Myanma</option><option value="158">Namíbia</option><option value="159">Nauru</option><option value="160">Nepal</option><option value="161">Nicarágua</option><option value="162">Níger</option><option value="163">Nigéria</option><option value="164">Niue</option><option value="165">Noruega</option><option value="166">Nova Caledônia</option><option value="167">Nova Zelândia</option><option value="168">Omã</option><option value="169">Panamá</option><option value="170">Papua-Nova Guiné</option><option value="171">Paquistão</option><option value="172">Paraguai</option><option value="173">Peru</option><option value="174">Pitcairn</option><option value="175">Polinésia Francesa</option><option value="176">Polônia</option><option value="177">Portugal</option><option value="178">Quênia</option><option value="179">Quirguistão</option><option value="180">Reino Unido</option><option value="181">República Centro-Africana</option><option value="182">República Dominicana</option><option value="183">República Tcheca</option><option value="184">Romênia</option><option value="185">Ruanda</option><option value="186">Russia</option><option value="187">Saara Ocidental</option><option value="188">Saint Kitts e Nevis</option><option value="189">Saint Pierre e Miquelon</option><option value="190">Samoa</option><option value="191">Santa Helena</option><option value="192">Santa Lúcia</option><option value="193">São Marino</option><option value="194">São Tomé e Príncipe</option><option value="195">São Vicente e Granadinas</option><option value="196">Senegal</option><option value="197">Serra Leoa</option><option value="198">Sérvia</option><option value="199">Seychelles</option><option value="200">Síria</option><option value="201">Somália</option><option value="202">Sri Lanka</option><option value="203">Suazilândia</option><option value="204">Sudão</option><option value="205">Suécia</option><option value="206">Suíça</option><option value="207">Suriname</option><option value="208">Tadjiquistão</option><option value="209">Tailândia</option><option value="210">Taiwan</option><option value="211">Tanzânia</option><option value="212">Territórios Britânicos do Oceano Índico</option><option value="213">Territórios Franceses do Sul</option><option value="214">Timor Oriental</option><option value="215">Togo</option><option value="216">Tokelau</option><option value="217">Tonga</option><option value="218">Trinidad e Tobago</option><option value="219">Tunísia</option><option value="220">Turcomenistão</option><option value="221">Turquia</option><option value="222">Tuvalu</option><option value="223">Ucrânia</option><option value="224">Uganda</option><option value="225">Uruguai</option><option value="226">Uzbequistão</option><option value="227">Vanuatu</option><option value="228">Venezuela</option><option value="229">Vietnã</option><option value="230">Zâmbia</option><option value="231">Zimbabwedd</option>
                </select>
            </div>
        
            <div class="grid-6-12">
                <label for="CEP">CEP <em class="formee-req">*</em></label>
                <input class="formee-medium" type="text" value="" name="CEP" id="CEP">
                <input type="submit" value="Buscar" title="Buscar">
            </div>
        
        
            <div class="grid-4-12">
                <label for="Endereco">Endereço <em class="formee-req">*</em></label>
                <input type="text" value="" name="Endereco" id="Endereco">
            </div>
        
            <div class="grid-4-12">
                <label for="Complemento">Complemento <em class="formee-req">*</em></label>
                <input type="text" value="" name="Complemento" id="Complemento">
            </div>

            <div class="grid-4-12">
                <label for="Bairro">Bairro <em class="formee-req">*</em></label>
                <input type="text" value="" name="Bairro" id="Bairro">
            </div>
        
        
            <div class="grid-6-12">
                <label for="Cidade">Cidade <em class="formee-req">*</em></label>
                <input type="text" value="" name="Cidade" id="Cidade">
            </div>
        
            <div class="grid-6-12">
                <label for="Estado">Estado <em class="formee-req">*</em></label>
                <select id="Estado">
                    <option value=""></option><option value="AC">AC</option><option value="AL">AL</option><option value="AM">AM</option><option value="AP">AP</option><option value="BA">BA</option><option value="CE">CE</option><option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option><option value="MA">MA</option><option value="MG">MG</option><option value="MS">MS</option><option value="MT">MT</option><option value="PA">PA</option><option value="PB">PB</option><option value="PE">PE</option><option value="PI">PI</option><option value="PR">PR</option><option value="RJ">RJ</option><option value="RN">RN</option><option value="RO">RO</option><option value="RR">RR</option><option value="RS">RS</option><option value="SC">SC</option><option value="SE">SE</option><option value="SP">SP</option><option value="TO">TO</option>
                </select>
            </div>
        
            <div style="clear:both;"></div>
        
            <div class="grid-4-12">
                <label for="Telefone">Telefone</label>
                <input type="text" value="" name="Telefone" id="Telefone">
            </div>
        
            <div class="grid-4-12">
                <label for="Celular">Celular</label>
                <input type="text" value="" name="Celular" id="Celular">
            </div>
        
            <div class="grid-4-12">
                <label for="Recados">Telefone para Recados</label>
                <input type="text" value="" name="Recados" id="Recados">
            </div>
            
            <div class="grid-12-12">
                <a href="#" id="btnEnviarDadosPessoais" class="formee-button">Salvar</a>
            </div>
        
    </fieldset>
    
    
    
    <!-- Experiencia Profissional -->
    
    <fieldset class="formCandidatoExperienciaProfissional">
        
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
            <label for="UltimoCargo">Ultimo Cargo <em class="formee-req">*</em></label>
            <input type="text" value="" name="UltimoCargo" id="UltimoCargo">
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
        
        
    </fieldset>
    
    <!-- Formacao Academica -->
    
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
    
    <div class="grid-12-12">
        <input type="submit" value="ENVIAR" title="ENVIAR" class="right">
    </div>
        
</form>