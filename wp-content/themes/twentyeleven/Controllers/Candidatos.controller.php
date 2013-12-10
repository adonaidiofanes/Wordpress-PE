<?php 

/*
function __autoload($classe){
    //$PATH = "http://127.0.0.1/wordpress/wp-content/themes/twentyeleven/";
    //$PATH = "C:\wamp\www\wordpress\wp-content\themes\twentyeleven\"";
    
    //require_once "http://127.0.0.1/wordpress/wp-content/themes/twentyeleven/Classes/" . $classe . ".class.php";
    //require_once $DirTemplate . "Classes\"" . $classe . '.class.php';
} */

/*----------------------------------------------------------------------------------*/
/* REQUISICOES VIA POST */
/*----------------------------------------------------------------------------------*/

if(isset($_POST)){
    /* AtualizarDadosCandidato */
    if($_POST['TipoCadastro'] == 'AtualizarCadastro'){

        include_once $_POST['DirTemplate'] . 'Classes/CandidatosDAO.class.php';
        include_once $_POST['DirTemplate'] . 'Classes/Candidatos.class.php';

        $DAO = new CandidatosDAO();

        $DAO->atualizarCadastro($_POST['Nome'], $_POST['Id'], $_POST['radioSexo'], $_POST['EstadoCivil'], $_POST['Nacionalidade'], $_POST['PaisAtual']);
        $DAO->atualizarEndereco($_POST['Id'], $_POST['Endereco'], $_POST['Complemento'], $_POST['Bairro'], $_POST['Cidade'], $_POST['Estado'], $_POST['CEP']);
        $DAO->atualizarTelefones($_POST);

        $Candidato = new Candidato($_POST['Id']);

        //$retorno = array('sucesso' => $Candidato->getJsonData() );
        $retorno = array('sucesso' => 'Dados atualizados com sucesso!' );

        echo json_encode($retorno);

    }

    /* NovoCadastro */
    if($_POST['TipoCadastro'] == 'NovoCadastro'){

        include_once $_POST['DirTemplate'] . 'Classes/CandidatosDAO.class.php';
        include_once $_POST['DirTemplate'] . 'Classes/Candidatos.class.php';

        $DAO = new CandidatosDAO();

        $retorno = $DAO->inserirCadastro($_POST);

        echo json_encode($retorno);

    }

} // Final da requisição $_POST'S

function setRetorno($msg, $ehJSON = false){
    if($ehJSON === true){
       $retorno = array('erro' => $msg);
       echo json_encode($retorno);
    }else{
        echo utf8_encode($msg);
    }
}

?>
