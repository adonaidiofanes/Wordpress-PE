<?php

/*----------------------------------------------------------------------------------*/
/* REQUISICOES VIA GET */
/*----------------------------------------------------------------------------------*/

if(isset($_GET)){
    if(isset($_GET['DirTemplate'])){
        include_once $_GET['DirTemplate'] . 'Classes/CandidatosDAO.class.php';
        include_once $_GET['DirTemplate'] . 'Classes/Candidatos.class.php';
    }
    
    if( isset($_GET['Acao']) && isset($_GET['Acao']) && ($_GET['Id']) ){
        // Excluir
        if($_GET['Acao'] == 'Excluir'){
            $DAO = new FormacaoAcademicaDAO();
            $retorno = $DAO->deleteFormacao($_GET['IdCandidato'], $_GET['Id']);
            echo json_encode($retorno);
        }
        // Editar
        if($_GET['Acao'] == 'Editar'){
            $DAO = new FormacaoAcademicaDAO();
            $retorno = $DAO->selectById($_GET['IdCandidato'], $_GET['Id']);
            
//            $Exp = new ExperienciaProfissional();
            
//            $Exp = array("Segmentos" => $Exp->listaSegmentosCandidato( $retorno['sucesso'][0]['IdSegmento'] ));
//            array_push($retorno['sucesso'], $Exp);

            echo json_encode($retorno);
        }
    }
}

/*----------------------------------------------------------------------------------*/
/* REQUISICOES VIA POST */
/*----------------------------------------------------------------------------------*/
if(isset($_POST)){
    
    if(isset($_POST['DirTemplate'])){
        include_once $_POST['DirTemplate'] . 'Classes/CandidatosDAO.class.php';
        include_once $_POST['DirTemplate'] . 'Classes/Candidatos.class.php';
    }
    
    // Adicionar nova Formacao Academica
    if(isset($_POST['IdCandidato']) && (!empty($_POST['IdCandidato'])) && (isset($_POST['Acao'])) && ($_POST['Acao'] == 'FormacaoFormMontarInserir') ){
        $Formacao = new FormacaoAcademica();
        
        echo json_encode(
                array('sucesso' => 
                        array('TipoCurso' => $Formacao->getTiposCursos(), 
                              'IdCandidato' => $_POST['IdCandidato']
                        )
                    )
                );
        return;
    }
    
    // Adicionar nova Formacao Academica
    if( isset($_POST['Acao']) && ($_POST['Acao'] == 'InserirFormacao') ){
        $retorno = new FormacaoAcademicaDAO();
        $arr = $retorno->addFormacao($_POST);
        
        $Formacao = new FormacaoAcademica();
        $Situacao = array("SituacaoNome" => $Formacao->verificarSituacao($_POST['Situacao']));
        
        array_push($arr['UltimaFormacao'], $Situacao);
        
        echo json_encode($arr);
        
//            $Exp = new ExperienciaProfissional();
            
//            $Exp = array("Segmentos" => $Exp->listaSegmentosCandidato( $retorno['sucesso'][0]['IdSegmento'] ));
//            array_push($retorno['sucesso'], $Exp);
    }
    
    // Atualizar Formacao
    if( isset($_POST['Acao']) && ($_POST['Acao'] == 'AtualizarFormacao') ){
        $retorno = new FormacaoAcademicaDAO();
        echo json_encode($retorno->updateFormacao($_POST));
    }
}

?>
