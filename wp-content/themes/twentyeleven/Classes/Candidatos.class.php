<?php

class Candidato {
    private $Id,
            $Nome,
            $DataNascimento,
            $Sexo,
            $EstadoCivil,
            $Nacionalidade,
            $DataCadastro,
            $PaisAtual,
            $Endereco,
            $Complemento,
            $Bairro,
            $Cidade,
            $Estado,
            $CEP,
            $TelRes,
            $TelCel,
            $TelRec,
            $Email,
            $Experiencia_Profissional,
            $Formacao_Academica;
    
    function __construct($Id) {
        
        $this->setId($Id);
        
        $ExpDAO = new ExperienciaProfissionalDAO();
        $this->setExperiencia_Profissional($ExpDAO->selecionarTodasExperiencias($Id));
        
        $Formacao = new FormacaoAcademicaDAO();
        $this->setFormacao_Academica($Formacao->selectAll($Id));

        $DAO = new CandidatosDAO();
        
        // Setar dados pessoais
        $arr = $DAO->selectById($Id);
        
        // Verificar se o objeto retorna pelo menos o nome do candidato para sabermos se
        // Existe esse usuario no BD
        if(isset($arr) && !empty($arr[0]['Nome'])){
            $this->setNome( $arr[0]['Nome'] );
            $this->setDataNascimento($arr[0]['DataNascimento']);
            $this->setSexo($arr[0]['Sexo']);
            $this->setEstadoCivil($arr[0]['EstadoCivil']);
            $this->setNacionalidade($arr[0]['Nacionalidade']);
            $this->setDataCadastro($arr[0]['DataCadastro']);
            $this->setPaisAtual($arr[0]['PaisAtual']);
            $this->setEmail($arr[0]['Email']);
        }
            // Setar dados de endereco
            $arr = $DAO->selectEndereco($Id);

        if(isset($arr) && !empty($arr[0]['Endereco'])){
            $this->setEndereco($arr[0]['Endereco']);
            $this->setComplemento($arr[0]['Complemento']);
            $this->setBairro($arr[0]['Bairro']);
            $this->setEstado($arr[0]['Estado']);
            $this->setCidade($arr[0]['Cidade']);
            $this->setCEP($arr[0]['CEP']);
        }

            // Telefones
            if( count($DAO->selectTelefone(1, $this->getId())) > 0 ){
                $arr = $DAO->selectTelefone(1, $this->getId() );
                $this->setTelRes( $arr[0]->Telefone );
                unset($arr);
            }

            if( count($DAO->selectTelefone(2, $this->getId())) > 0 ){
                $arr = $DAO->selectTelefone(2, $this->getId());
                $this->setTelCel( $arr[0]->Telefone );
                unset($arr);
            }

            if( count($DAO->selectTelefone(3, $this->getId())) > 0 ){
                $arr = $DAO->selectTelefone(3, $this->getId());
                $this->setTelRec( $arr[0]->Telefone );
                unset($arr);
            }
    }
    
    /*
     * Essa função serve para retornar objetos por jSON
     * Sem esssa funcao os objetos dentro do JSON sao retornados assim: [Nome:Candidato:private] => Adonai Diofanes
     * Fonte: http://stackoverflow.com/questions/6836592/serializing-php-object-to-json
     */
    function getJsonData(){
        $var = get_object_vars($this);
        foreach($var as &$value){
            if(is_object($value) && method_exists($value,'getJsonData')){
                $value = $value->getJsonData();
            }
        }
        return $var;
    }
    
    public function listaPais($Pais, $nameSelect){
        $DAO = new CandidatosDAO;
        $arr = $DAO->selectPais();
        
        $conteudo = '';
        $s = ''; // Variavel que seta o selected
        
        foreach ($arr as $key => $value) {
            
            $Id = $arr[$key]['Id'];
            $Nome = $arr[$key]['Nome'];
            
            if( $Pais == $Id ){ $s = ' selected'; } else { $s = ''; }
            
            $conteudo = $conteudo . "<option value='$Id'$s>$Nome</option>" . PHP_EOL;
            
        }
        
        $retorno = '<select id="'.$nameSelect.'" name="'.$nameSelect.'">' . $conteudo . '</select>';
        return $retorno;        
    }
    
    public function listaEstado(){
        
        $estados = array("AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amapá","BA"=>"Bahia","CE"=>"Ceará","DF"=>"Distrito Federal","ES"=>"Espírito Santo","GO"=>"Goiás","MA"=>"Maranhão","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Pará","PB"=>"Paraíba","PR"=>"Paraná","PE"=>"Pernambuco","PI"=>"Piauí","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo","TO"=>"Tocantins");
        $conteudo = '';
        
        foreach ($estados as $key => $value) {
            
            if($this->getEstado() == $key){$s=' selected';} else {$s='';}
            
            $conteudo = $conteudo . "<option value='$key'$s>$value</option>" . PHP_EOL;
        }
        
        return '<select id="Estado" name="Estado">' . $conteudo . '</select>';
        
    }
    
    public function getId() {
        return $this->Id;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getNome() {
        return $this->Nome;
    }

    public function setNome($Nome) {
        $this->Nome = $Nome;
    }

    public function getDataNascimento() {
        return $this->DataNascimento;
    }

    public function setDataNascimento($DataNascimento) {
        
        if( $DataNascimento != '' && $DataNascimento != null){
            $this->DataNascimento = date("d/m/Y", strtotime($DataNascimento));
        } else {
            $this->DataNascimento = '';
        }
        //$this->DataNascimento = $DataNascimento;
    }

    public function getSexo() {
        return $this->Sexo;
    }

    public function setSexo($Sexo) {
        $this->Sexo = $Sexo;
    }

    public function getEstadoCivil() {
        return $this->EstadoCivil;
    }

    public function setEstadoCivil($EstadoCivil) {
        $this->EstadoCivil = $EstadoCivil;
    }

    public function getNacionalidade() {
        return $this->Nacionalidade;
    }

    public function setNacionalidade($Nacionalidade) {
        $this->Nacionalidade = $Nacionalidade;
    }

    public function getDataCadastro() {
        return $this->DataCadastro;
    }

    public function setDataCadastro($DataCadastro) {
        $this->DataCadastro = $DataCadastro;
    }
    
    public function getPaisAtual() {
        return $this->PaisAtual;
    }

    public function setPaisAtual($PaisAtual) {
        $this->PaisAtual = $PaisAtual;
    }
    
    public function getEndereco() {
        return $this->Endereco;
    }

    public function setEndereco($Endereco) {
        $this->Endereco = $Endereco;
    }

    public function getComplemento() {
        return $this->Complemento;
    }

    public function setComplemento($Complemento) {
        $this->Complemento = $Complemento;
    }

    public function getBairro() {
        return $this->Bairro;
    }

    public function setBairro($Bairro) {
        $this->Bairro = $Bairro;
    }

    public function getCidade() {
        return $this->Cidade;
    }

    public function setCidade($Cidade) {
        $this->Cidade = $Cidade;
    }

    public function getEstado() {
        return $this->Estado;
    }

    public function setEstado($Estado) {
        $this->Estado = $Estado;
    }
    
    public function getCEP() {

        // Adicionar traco (-) no CEP
        $CEP = null;
        if(!empty($this->CEP)){
            $CEP = substr($this->CEP, 0, -3);
            $CEP = $CEP . '-' . substr($this->CEP, 5, 3);
        }
        return $CEP;
    }

    public function setCEP($CEP) {
        $this->CEP = $CEP;
    }
    
    public function getTelRes() {
        return $this->TelRes;
    }

    public function setTelRes($TelRes) {
        $this->TelRes = $TelRes;
    }

    public function getTelCel() {
        return $this->TelCel;
    }

    public function setTelCel($TelCel) {
        $this->TelCel = $TelCel;
    }

    public function getTelRec() {
        return $this->TelRec;
    }

    public function setTelRec($TelRec) {
        $this->TelRec = $TelRec;
    }
    
    public function getEmail() {
        return $this->Email;
    }

    public function setEmail($Email) {
        $this->Email = $Email;
    }
    
    public function getExperiencia_Profissional() {
        return $this->Experiencia_Profissional;
    }

    public function setExperiencia_Profissional($Experiencia_Profissional) {
        $this->Experiencia_Profissional = $Experiencia_Profissional;
    }
    
    public function setFormacao_Academica($Formacao_Academica) {
        $this->Formacao_Academica = $Formacao_Academica;
    }
    
    public function getFormacao_Academica() {
        return $this->Formacao_Academica;
    }

}

class ExperienciaProfissional {
    private $Id,
            $IdCandidato,
            $Nome_Empresa,
            $IdSegmento,
            $Data_Entrada,
            $Data_Saida,
            $Ultimo_Cargo,
            $Atividades_Desenvolvidas,
            $Emprego_Atual;
    
    public function mostrarExperiencias($Exp){
        
        $template = "<tr class='linha@Id '>" .
                        "<td>@Empresa</td>" .
                        "<td>@Cargo</td>" .
                        "<td>@Data_Entrada</td>" .
                        "<td>@Data_Saida</td>" .
                        "<td><a class='Editar' id='@Id' title='Editar' href='#'>Editar</a></td>" .
                        "<td><a class='Excluir' id='@Id' title='Excluir' href='#'>Excluir</a></td>" .
                    "</tr>";
        
        $retorno = "";
        if( count($Exp)>0 ){
            for( $i=0;$i<count($Exp);$i++ ){
                $Montar = str_replace("@Empresa", $Exp[$i]->Nome_Empresa, $template);
                $Montar = str_replace("@Cargo", $Exp[$i]->Cargo, $Montar);
                $Montar = str_replace("@Data_Entrada", $Exp[$i]->Data_Entrada, $Montar);
                $Montar = str_replace("@Data_Saida", $Exp[$i]->Data_Saida, $Montar);
                $Montar = str_replace("@Data_Saida", $Exp[$i]->Data_Saida, $Montar);
                $Montar = str_replace("@Id", $Exp[$i]->Id, $Montar);
                $retorno = $retorno . $Montar;
            }
        } else {
            $retorno = "Sem experiências cadastradas";
        }
        return $retorno;
    }

    public function listaSegmentosCandidato($segmentoSelecionado){
        $DAO = new ExperienciaProfissionalDAO;
        $arr = $DAO->selectAllSegmentos();
        
        $conteudo = '';
        $s = ''; // Variavel que seta o selected
        
        foreach ($arr as $key => $value) {
            
            $Id = $arr[$key]['Id'];
            $Nome = $arr[$key]['Nome'];
            
            if( $segmentoSelecionado == $Id ){ $s = ' selected'; } else { $s = ''; }
            
            $conteudo = $conteudo . "<option value='$Id'$s>$Nome</option>" . PHP_EOL;
            
        }
        
        $retorno = '<select id="IdSegmento" name="IdSegmento">' . $conteudo . '</select>';
        return $retorno;        
    }
    
    public function getNome_Empresa() {
        return $this->Nome_Empresa;
    }

    public function setNome_Empresa($Nome_Empresa) {
        $this->Nome_Empresa = $Nome_Empresa;
    }

        public function getData_Entrada() {
        return $this->Data_Entrada;
    }

    public function setData_Entrada($Data_Entrada) {
        $this->Data_Entrada = $Data_Entrada;
    }

    public function getData_Saida() {
        return $this->Data_Saida;
    }

    public function setData_Saida($Data_Saida) {
        $this->Data_Saida = $Data_Saida;
    }

    public function getUltimo_Cargo() {
        return $this->Ultimo_Cargo;
    }

    public function setUltimo_Cargo($Ultimo_Cargo) {
        $this->Ultimo_Cargo = $Ultimo_Cargo;
    }

    public function getAtividades_Desenvolvidas() {
        return $this->Atividades_Desenvolvidas;
    }

    public function setAtividades_Desenvolvidas($Atividades_Desenvolvidas) {
        $this->Atividades_Desenvolvidas = $Atividades_Desenvolvidas;
    }

    public function getEmprego_Atual() {
        return $this->Emprego_Atual;
    }

    public function setEmprego_Atual($Emprego_Atual) {
        $this->Emprego_Atual = $Emprego_Atual;
    }

        public function getId() {
        return $this->Id;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }
    
    public function getIdCandidato() {
        return $this->IdCandidato;
    }

    public function setIdCandidato($IdCandidato) {
        $this->IdCandidato = $IdCandidato;
    }
    
    public function getIdSegmento() {
        return $this->IdSegmento;
    }

    public function setIdSegmento($IdSegmento) {
        $this->IdSegmento = $IdSegmento;
    }

}

class FormacaoAcademica {

    private $Id,
            $IdCandidato,
            $IdTipoCurso,
            $Nome_Instituicao,
            $Nome_Curso,
            $Situacao,
            $Data_Conclusao,
            $Data_Insercao,
            $Data_Atualizacao;
    
    public function getId() {
        return $this->Id;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getIdCandidato() {
        return $this->IdCandidato;
    }

    public function setIdCandidato($IdCandidato) {
        $this->IdCandidato = $IdCandidato;
    }

    public function getIdTipoCurso() {
        return $this->IdTipoCurso;
    }

    public function setIdTipoCurso($IdTipoCurso) {
        $this->IdTipoCurso = $IdTipoCurso;
    }

    public function getNome_Instituicao() {
        return $this->Nome_Instituicao;
    }

    public function setNome_Instituicao($Nome_Instituicao) {
        $this->Nome_Instituicao = $Nome_Instituicao;
    }

    public function getNome_Curso() {
        return $this->Nome_Curso;
    }

    public function setNome_Curso($Nome_Curso) {
        $this->Nome_Curso = $Nome_Curso;
    }

    public function getSituacao() {
        return $this->Situacao;
    }

    public function setSituacao($Situacao) {
        $this->Situacao = $Situacao;
    }

    public function getData_Conclusao() {
        return $this->Data_Conclusao;
    }

    public function setData_Conclusao($Data_Conclusao) {
        $this->Data_Conclusao = $Data_Conclusao;
    }
    
    public function getData_Insercao() {
        return $this->Data_Insercao;
    }

    public function setData_Insercao($Data_Insercao) {
        $this->Data_Insercao = $Data_Insercao;
    }

    public function getData_Atualizacao() {
        return $this->Data_Atualizacao;
    }

    public function setData_Atualizacao($Data_Atualizacao) {
        $this->Data_Atualizacao = $Data_Atualizacao;
    }
    
    public function showFormacoes($Formacoes){
        
        $template = "<tr class='linha@Id '>" .
                        "<td>@Instituicao</td>" .
                        "<td>@Tipo @Curso</td>" .
                        "<td>@Situacao</td>" .
                        "<td>@Data_Conclusao</td>" .
                        "<td><a class='Editar' id='@Id' title='Editar' href='#'>Editar</a></td>" .
                        "<td><a class='Excluir' id='@Id' title='Excluir' href='#'>Excluir</a></td>" .
                    "</tr>";
        
        $retorno = "";
        if( count($Formacoes)>0 ){
            for( $i=0;$i<count($Formacoes);$i++ ){
                $Montar = str_replace("@Instituicao", $this->verificarFormacao($Formacoes[$i]->Nome_Instituicao), $template);
                $Montar = str_replace("@Curso", $this->verificarFormacao($Formacoes[$i]->Nome_Curso), $Montar);
                $Montar = str_replace("@Situacao", $this->verificarSituacao($Formacoes[$i]->Situacao), $Montar);
                $Montar = str_replace("@Data_Conclusao", $this->verificarFormacao($Formacoes[$i]->Data_Conclusao), $Montar);
                $Montar = str_replace("@Id", $this->verificarFormacao($Formacoes[$i]->Id), $Montar);
                $Montar = str_replace("@Tipo", $this->verificarFormacao($Formacoes[$i]->GrauFormacao), $Montar);
                $retorno = $retorno . $Montar;
            }
        } else {
            $retorno = "Sem formações acadêmicas cadastradas";
        }
        return $retorno;
    }
    
    public function verificarFormacao($str){
        if( !empty($str) ){ return $str; }
        else { return ""; }
    }
    
    public function verificarSituacao($str){
        // 1: Concluido, 2: Cursando, 3: Interrompido
        switch($str){
            case 1 : return "Concluído"; break;
            case 2 : return "Cursando"; break;
            case 3 : return "Interrompido"; break;
            default : "Não informado";
        }
    }
    
    /**
     * SELECIONA TODOS OS TIPOS DE CURSOS DISPONIVEIS NA TABELA FORMACAO_TIPO
     * RETORNA UM OPTION SELECT HTML COM OS TIPOS DE CURSO
     *
     * @param $tipoSelecionado Caso o candidato tenha um curso selecionado
     */
    public function getTiposCursos($tipoSelecionado = NULL){
        $DAO = new FormacaoAcademicaDAO();
        $arr = $DAO->selectAllTipoCurso();
        
        $conteudo = '';
        $s = ''; // Variavel que seta o selected
        
        foreach ($arr as $key => $value) {
            
            $Id = $arr[$key]['Id'];
            $Nome = $arr[$key]['Nome'];
            
            if( $tipoSelecionado == $Id ){ $s = ' selected'; } else { $s = ''; }
            
            $conteudo = $conteudo . "<option value='$Id'$s>$Nome</option>" . PHP_EOL;
            
        }
        
        $retorno = '<select id="IdTipoCurso" name="IdTipoCurso">' . $conteudo . '</select>';
        return $retorno;        
    }

}

?>
