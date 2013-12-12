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
            $DAO = new ExperienciaProfissionalDAO();
            $retorno = $DAO->apagarExperiencia($_GET['IdCandidato'], $_GET['Id']);
            echo json_encode($retorno);
        }
        // Editar
        if($_GET['Acao'] == 'Editar'){
            $DAO = new ExperienciaProfissionalDAO();
            $retorno = $DAO->selecionarUmaExperiencia($_GET['IdCandidato'], $_GET['Id']);
            
            $Exp = new ExperienciaProfissional();
            
            $Exp = array("Segmentos" => $Exp->listaSegmentosCandidato( $retorno['sucesso'][0]['IdSegmento'] ));
            array_push($retorno['sucesso'], $Exp);

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
    
    // Adicionar nova experiência
    if(isset($_POST['IdCandidato']) && (!empty($_POST['IdCandidato'])) && (isset($_POST['Acao'])) && ($_POST['Acao'] == 'ExperienciasFormMontarInserir') ){
        $Exp = new ExperienciaProfissional();
        
        echo json_encode(
                array('sucesso' => 
                        array('Segmento' => $Exp->listaSegmentosCandidato(null), 
                              'IdCandidato' => $_POST['IdCandidato']
                        )
                    )
                );
        return;
    }
    
    // Adicionar nova experiência
    if( isset($_POST['Acao']) && ($_POST['Acao'] == 'InserirExperiencia') ){
        $retorno = new ExperienciaProfissionalDAO();
        echo json_encode($retorno->inserirExperiencia($_POST));
    }
    
    // Atualizar experiência
    if( isset($_POST['Acao']) && ($_POST['Acao'] == 'AtualizarExperiencia') ){
        $retorno = new ExperienciaProfissionalDAO();
        echo json_encode($retorno->atualizarExperiencia($_POST));
    }
}

?>
