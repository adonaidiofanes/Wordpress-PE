<?phpclass CandidatosDAO {    public $bd = null;    public function __construct(){        require_once "Conexao.class.php";        $this->bd = new Conexao();    }        public function selectById($idCandidato){        try{                $query = "SELECT Id, Nome, Email, DataNascimento, Sexo, EstadoCivil, Nacionalidade, PaisAtual, DataCadastro FROM candidatos WHERE Id = ?";            $stmt = $this->bd->prepare($query);            $stmt->bindValue(1, $idCandidato);            $stmt->execute();                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);                        return $result;                    }catch(PDOException $e){                        echo "Erro ao selecionar Candidato: " . $idCandidato . ' <br />' . $e->getMessage();        }    }        public function selectEndereco($idCandidato){        try{                $query = "SELECT Endereco, Complemento, Bairro, Cidade, Estado, CEP FROM endereco WHERE IdCandidato = ?";            $stmt = $this->bd->prepare($query);            $stmt->bindValue(1, $idCandidato);            $stmt->execute();                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);                        return $result;                    }catch(PDOException $e){                        echo "Erro ao selecionar Candidato: " . $idCandidato . ' <br />' . $e->getMessage();        }    }        public function selectPais(){        try{                        $query = "SELECT * FROM paises";            $stmt = $this->bd->prepare($query);            $stmt->execute();            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            return $result;        } catch (PDOException $e){            echo "Erro ao selecionar os paises " . $e->getMessage();        }    }        public function selectTelefone($tipo, $IdCandidato){        try {                $query = "SELECT Id, Telefone FROM telefones WHERE Tipo = ? AND IdCandidato = ?";                $stmt = $this->bd->prepare($query);                $stmt->bindValue(1, $tipo);                $stmt->bindValue(2, $IdCandidato);                $stmt->execute();                                $r = $stmt->fetchAll(PDO::FETCH_OBJ);                                return $r;                            } catch (PDOException $exc) {                echo "Erro em selecionar telefone" . $exc->getTraceAsString();            }        }        /* @TODO : Fazer a atualizacao para data de nascimento */    public function atualizarCadastro($Nome, $IdCandidato, $Sexo, $EstadoCivil, $Nacionalidade, $PaisAtual){        try {                $query = 'UPDATE candidatos SET Nome = :Nome, '.                          'Sexo          = :Sexo, ' .                                               'EstadoCivil   = :EstadoCivil, ' .                                  'Nacionalidade = :Nacionalidade, ' .                              'PaisAtual     = :PaisAtual ' .                                      'WHERE Id      = :Id';                                $stmt = $this->bd->prepare($query);                                $stmt->bindValue(':Nome', $Nome, PDO::PARAM_STR);                $stmt->bindValue(':Sexo', $Sexo, PDO::PARAM_STR);                $stmt->bindValue(':EstadoCivil', $EstadoCivil, PDO::PARAM_INT);                $stmt->bindValue(':Id', $IdCandidato, PDO::PARAM_INT);                $stmt->bindValue(':Nacionalidade', $Nacionalidade, PDO::PARAM_INT);                $stmt->bindValue(':PaisAtual', $PaisAtual, PDO::PARAM_INT);                                $stmt->execute();                                $r = $stmt->rowCount();                                return $r;                            } catch (PDOException $exc) {                echo "Erro: Nao consegui atualizar o nome" . $exc->getTraceAsString();            }        }            public function atualizarEndereco($IdCandidato, $Endereco, $Complemento, $Bairro, $Cidade, $Estado, $CEP){        try {                            $query = 'UPDATE endereco SET ' .                         'Endereco      = :Endereco, ' .                          'Complemento   = :Complemento, ' .                                               'Bairro        = :Bairro, ' .                                  'Cidade        = :Cidade, ' .                              'Estado        = :Estado, ' .                                      'CEP           = :CEP ' .                                      'WHERE IdCandidato = :IdCandidato';                                $stmt = $this->bd->prepare($query);                                $stmt->bindValue(':Endereco', $Endereco, PDO::PARAM_STR);                $stmt->bindValue(':Complemento', $Complemento, PDO::PARAM_STR);                $stmt->bindValue(':Bairro', $Bairro, PDO::PARAM_STR);                $stmt->bindValue(':Cidade', $Cidade, PDO::PARAM_STR);                $stmt->bindValue(':Estado', $Estado, PDO::PARAM_STR);                $stmt->bindValue(':CEP', str_replace("-", "", $CEP), PDO::PARAM_STR);                $stmt->bindValue(':IdCandidato', $IdCandidato, PDO::PARAM_INT);                                $stmt->execute();                                $r = $stmt->rowCount();                                return $r;                            } catch (PDOException $exc) {                echo "Erro: Nao consegui atualizar o Endereco" . $exc->getTraceAsString();            }        }            public function atualizarTelefones($objPost){        try {                                $IdCandidato = $objPost['Id'];                                // Telefone         - Tipo 1                $tipo = 1;                $query = "UPDATE telefones SET Telefone = :Telefone WHERE Tipo = $tipo AND IdCandidato = :IdCandidato";                $stmt = $this->bd->prepare($query);                $stmt->bindValue(':Telefone', $objPost['Telefone'], PDO::PARAM_STR);                $stmt->bindValue(':IdCandidato', $objPost['Id'], PDO::PARAM_INT);                $stmt->execute();                                // Telefone Celular - Tipo 2                $tipo = 2;                $query = "UPDATE telefones SET Telefone = :TelCelular WHERE Tipo = $tipo AND IdCandidato = :IdCandidato";                $stmt = $this->bd->prepare($query);                $stmt->bindValue(':TelCelular', $objPost['TelCelular'], PDO::PARAM_STR);                $stmt->bindValue(':IdCandidato', $objPost['Id'], PDO::PARAM_INT);                $stmt->execute();                                // Telefone Recados - Tipo 3                $tipo = 3;                                // Verificar se existe, se nao existir e existir o POST_TelRecados => Cadastrar novo                $resultadoTelRec = $this->selectTelefone($tipo, $IdCandidato);                if( (count($resultadoTelRec) == 0) && (!empty($objPost['TelRecados'])) ){                    $query = "INSERT INTO telefones (IdCandidato, Telefone, Tipo) VALUES (:IdCandidato, :TelRecados, $tipo)";                    $stmt = $this->bd->prepare($query);                    $stmt->bindValue(':TelRecados', $objPost['TelRecados'], PDO::PARAM_INT);                    $stmt->bindValue(':IdCandidato', $objPost['Id'], PDO::PARAM_INT);                    $stmt->execute();                }                                // Verificar se existe, caso existe e exista o POST_TelRecaods == null => Apagar registro                if( (count($resultadoTelRec) > 0) && (empty($objPost['TelRecados'])) ){                    $query = "DELETE FROM telefones WHERE IdCandidato = $IdCandidato AND Tipo = $tipo";                    $stmt = $this->bd->prepare($query);                    $stmt->execute();                }                // Verificar se existe, caso existe e exista o POST_TelRecados => Atualizar                 if( (count($resultadoTelRec) > 0) && (!empty($objPost['TelRecados'])) ){                    $query = "UPDATE telefones SET Telefone = :TelRecados WHERE IdCandidato = $IdCandidato AND Tipo = $tipo";                    $stmt = $this->bd->prepare($query);                    $stmt->bindValue(':TelRecados', $objPost['TelRecados'], PDO::PARAM_STR);                    $stmt->execute();                }                            } catch (PDOException $exc) {                echo "Erro: Nao consegui atualizar o Telefone" . $exc->getTraceAsString();            }        }            /* Inserção de dados do Candidato */    public function inserirCadastro($objPost){        try {                // Inserção de dados pessoais                $retorno = $this->inserirDadosPessoais($objPost);                if( $retorno == 'erro' ){                    return array("erro" => "Ocorreu um erro ao inserir seus dados pessoais. Entre em contato conosco através da página de contato detalhando o ocorrido.");                }                                // Inserção de Telefones ( Tipos > 1: Telefone; 2: Celular; 3: Recados )                // Inserir Telefone Residencial                $retorno = $this->inserirTelefone($objPost['Telefone'], 1, $objPost['Id']);                if($retorno == 'erro'){                    return array("erro" => "Ocorreu um erro ao inserir o Telefone");                }                                // Inserir Telefone Celular                $retorno = $this->inserirTelefone($objPost['TelCelular'], 2, $objPost['Id']);                if($retorno == 'erro'){                    return array("erro" => "Ocorreu um erro ao inserir o Telefone Celular");                }                                // Inserir Telefone Recados                if( $objPost['TelRecados'] != NULL ){                    $retorno = $this->inserirTelefone($objPost['TelRecados'], 3, $objPost['Id']);                    if($retorno == 'erro'){                        return array("erro" => "Ocorreu um erro ao inserir o Telefone de Recados");                    }                }                                // Inserção de Endereço                if( isset($objPost['Complemento']) && (!empty($objPost['Complemento'])) ){                    $Complemento = $objPost['Complemento'];                } else { $Complemento = NULL; }                                $CEP = str_replace("-", "", $objPost['CEP']);                                $retorno = $this->inserirEndereco($objPost['Id'], $objPost['Endereco'], $objPost['Complemento'], $objPost['Bairro'], $objPost['Cidade'], $objPost['Estado'], $CEP);                if($retorno == 'erro'){                    return array("erro" => "Ocorreu um erro ao inserir o endereço!");                }                return array("sucesso" => "Os dados cadastrais foram inseridos com sucesso!");            } catch (PDOException $exc) {                return "Erro: Nao consegui inserir os dados cadastrais" . $exc->getTraceAsString();            }        }            public function inserirEndereco($IdCandidato, $Endereco, $Complemento, $Bairro, $Cidade, $Estado, $CEP){        try{            $query = 'INSERT INTO endereco (IdCandidato, Endereco, Complemento, Bairro, Cidade, Estado, CEP) VALUES (' .                      ':IdCandidato, :Endereco, :Complemento, :Bairro, :Cidade, :Estado, :CEP)';                    $stmt = $this->bd->prepare($query);                    $stmt->bindValue(':IdCandidato',$IdCandidato,PDO::PARAM_INT);                    $stmt->bindValue(':Complemento',$Complemento,PDO::PARAM_STR);                    $stmt->bindValue(':Endereco',   $Endereco,   PDO::PARAM_STR);                    $stmt->bindValue(':Bairro',     $Bairro,     PDO::PARAM_STR);                    $stmt->bindValue(':Cidade',     $Cidade,     PDO::PARAM_STR);                    $stmt->bindValue(':Estado',     $Estado,     PDO::PARAM_STR);                    $stmt->bindValue(':CEP',        $CEP,        PDO::PARAM_STR);            if($stmt->execute())                return "sucesso";            else                return "erro";                            } catch (PDOException $exc) {                return "Erro: Nao consegui inserir o endereco" . $exc->getTraceAsString();            }    }    public function inserirTelefone($Telefone, $Tipo, $IdCandidato){        try{            $query = 'INSERT INTO telefones (IdCandidato, Telefone, Tipo) VALUES (' .                      ':IdCandidato, :Telefone, :Tipo)';                    $stmt = $this->bd->prepare($query);                    $stmt->bindValue(':Telefone',   $Telefone,      PDO::PARAM_STR);                    $stmt->bindValue(':Tipo',       $Tipo,          PDO::PARAM_INT);                    $stmt->bindValue(':IdCandidato',$IdCandidato,   PDO::PARAM_INT);                            if($stmt->execute())                return "sucesso";            else                return "erro";                            } catch (PDOException $exc) {                return "Erro: Nao consegui inserir o telefone" . $exc->getTraceAsString();            }    }        /* Inserção de dados do Candidato */    /* @TODO : Fazer o metodo para tratar a data de nascimento na hora de inserir */    public function inserirDadosPessoais($objPost){        try {                                $query = 'INSERT INTO candidatos (Id, Nome, Email, DataNascimento, Sexo, EstadoCivil, Nacionalidade, PaisAtual, DataCadastro) VALUES ('.                          ':Id, :Nome, :Email, :DataNascimento, :Sexo, :EstadoCivil, :Nacionalidade, :PaisAtual, NOW())';                $stmt = $this->bd->prepare($query);                $stmt->bindValue(':Id', $objPost['Id'], PDO::PARAM_STR);                $stmt->bindValue(':Nome', $objPost['Nome'], PDO::PARAM_STR);                $stmt->bindValue(':Email', $objPost['Email'], PDO::PARAM_STR);                $stmt->bindValue(':DataNascimento', $objPost['DataNascimento'], PDO::PARAM_STR);                $stmt->bindValue(':Sexo', $objPost['radioSexo'], PDO::PARAM_STR);                $stmt->bindValue(':EstadoCivil', $objPost['EstadoCivil'], PDO::PARAM_INT);                $stmt->bindValue(':Nacionalidade', $objPost['Nacionalidade'], PDO::PARAM_INT);                $stmt->bindValue(':PaisAtual', $objPost['PaisAtual'], PDO::PARAM_INT);                if($stmt->execute())                    return "sucesso";                else                    return "erro";                            } catch (PDOException $exc) {                return "Erro: Nao foi possivel inserir os dados cadastrais" . $exc->getTraceAsString();            }        }    public function __destruct() {        $this->bd = null;    }    }class ExperienciaProfissionalDAO{    public $bd = null;    public function __construct(){        require_once "Conexao.class.php";        $this->bd = new Conexao();    }        public function selecionarTodasExperiencias($idCandidato){        try{                $query = "SELECT * FROM experiencia_profissional WHERE IdCandidato = ? ORDER BY Id DESC";            $stmt = $this->bd->prepare($query);            $stmt->bindValue(1, $idCandidato);            $stmt->execute();                        $result = $stmt->fetchAll(PDO::FETCH_OBJ);                        return $result;                    }catch(PDOException $e){                        echo "Erro ao selecionar experiencia profissional: " . $idCandidato . ' <br />' . $e->getMessage();        }    }        /*----------------------------------------------------------------------------------*/    /* LISTAR TODOS SEGMENTOS */    /*----------------------------------------------------------------------------------*/    public function selectAllSegmentos(){        try{                        $query = "SELECT * FROM experiencia_segmentos ORDER BY Nome ASC";            $stmt = $this->bd->prepare($query);            $stmt->execute();            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            return $result;        } catch (PDOException $e){            echo "Erro ao selecionar os segmentos " . $e->getMessage();        }    }    /*----------------------------------------------------------------------------------*/    /* APAGAR EXPERIENCIA PROFISSIONAL */    /*----------------------------------------------------------------------------------*/    public function apagarExperiencia($idCandidato, $IdExp){        try{                    $query = "DELETE FROM experiencia_profissional WHERE IdCandidato = ".$idCandidato." AND Id = " . $IdExp;                $stmt = $this->bd->prepare($query);            if($stmt->execute()){                $r = array("sucesso" => "Experiência apagada com sucesso!", "IdApagar" => $IdExp);                return $r;            }            else{                return array("erro" => "Erro ao apagar a experiência!");            }                    }catch(PDOException $e){                        echo "Erro ao selecionar apagar experiência profissional: " . $idCandidato . ' <br />' . $e->getMessage();        }    }        /*----------------------------------------------------------------------------------*/    /* SELECIONAR UMA EXPERIENCIA PROFISSIONAL */    /*----------------------------------------------------------------------------------*/    public function selecionarUmaExperiencia($idCandidato, $IdExp){        try{                $query = "SELECT * FROM experiencia_profissional WHERE IdCandidato = ? AND Id = ?";            $stmt = $this->bd->prepare($query);            $stmt->bindValue(1, $idCandidato);            $stmt->bindValue(2, $IdExp);            $stmt->execute();                        $result = array("sucesso" => $stmt->fetchAll(PDO::FETCH_ASSOC));                        return $result;                    }catch(PDOException $e){                        return array("erro" => "Erro ao selecionar experiencia profissional: " . $idCandidato . ' <br />' . $e->getMessage());        }    }        /*----------------------------------------------------------------------------------*/    /* ULTIMA EXPERIENCIA DO CANDIDATO */    /*----------------------------------------------------------------------------------*/    public function ultimaExperiencia($idCandidato){        try{                        $query = "SELECT * FROM experiencia_profissional WHERE IdCandidato = ? ORDER BY ID DESC LIMIT 1";            $stmt = $this->bd->prepare($query);            $stmt->bindValue(1, $idCandidato);            $stmt->execute();            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            return $result;        } catch (PDOException $e){            echo "Erro ao selecionar os segmentos " . $e->getMessage();        }    }        /*----------------------------------------------------------------------------------*/    /* ADICIONAR UMA NOVA EXPERIENCIA PROFISSIONAL */    /*----------------------------------------------------------------------------------*/    public function inserirExperiencia($_POST){        try{            $query = 'INSERT INTO experiencia_profissional (IdCandidato, Nome_Empresa, IdSegmento, Data_Entrada, Data_Saida, Cargo, Atividades_Desenvolvidas, Emprego_Atual, Data_Insercao, Data_Atualizacao) VALUES (' .                      ':IdCandidato, :Nome_Empresa, :IdSegmento, :Data_Entrada, :Data_Saida, :Cargo, :Atividades_Desenvolvidas, :Emprego_Atual, NOW(), NOW())';                    $stmt = $this->bd->prepare($query);                    $stmt->bindValue(':IdCandidato',   $_POST['IdCandidato'], PDO::PARAM_INT);                    $stmt->bindValue(':Nome_Empresa',  $_POST['Nome_Empresa'], PDO::PARAM_STR);                    $stmt->bindValue(':IdSegmento',    $_POST['IdSegmento'], PDO::PARAM_INT);                    $stmt->bindValue(':Data_Entrada',  $_POST['Data_Entrada'], PDO::PARAM_STR);                    $stmt->bindValue(':Data_Saida',    $_POST['Data_Saida'], PDO::PARAM_STR);                    $stmt->bindValue(':Cargo',         $_POST['Cargo'], PDO::PARAM_STR);                    $stmt->bindValue(':Atividades_Desenvolvidas',   $_POST['Atividades_Desenvolvidas'], PDO::PARAM_STR);                    $stmt->bindValue(':Emprego_Atual', $_POST['Emprego_Atual'], PDO::PARAM_INT);                        // Se for inserida com sucesso, vamos pegar o ID da ultima experiencia do usuario para colocarmos no retorno do JSON            if($stmt->execute()){                return array("sucesso" => array("Experiência profissional adicionada com sucesso!"),                              "UltimaExperiencia" => $this->ultimaExperiencia($_POST['IdCandidato'])                            );            } else {                return array("erro" => "Não foi possível adicionar a experiência, tente mais tarde!");            }                            } catch (PDOException $exc) {                return "Erro: Nao consegui inserir a experiencia profissonal" . $exc->getTraceAsString();            }    }        /*----------------------------------------------------------------------------------*/    /* ATUALIZAR UMA EXPERIENCIA PROFISSIONAL */    /*----------------------------------------------------------------------------------*/    public function atualizarExperiencia($_POST){        try {                $query = 'UPDATE experiencia_profissional SET '.                         'Nome_Empresa  = :Nome_Empresa, '.                                      'IdSegmento    = :IdSegmento, '.                                      'Data_Entrada  = :Data_Entrada, '.                                      'Data_Saida    = :Data_Saida, '.                                      'Cargo         = :Cargo, '.                                      'Emprego_Atual = :Emprego_Atual, '.                                      'Atividades_Desenvolvidas = :Atividades_Desenvolvidas, '.                                      'Data_Atualizacao = NOW() '.                                      'WHERE Id      = :Id AND ' .                         'IdCandidato   = :IdCandidato';                                $stmt = $this->bd->prepare($query);                                $stmt->bindValue(':Nome_Empresa', $_POST['Nome_Empresa'], PDO::PARAM_STR);                $stmt->bindValue(':IdSegmento', $_POST['IdSegmento'], PDO::PARAM_INT);                $stmt->bindValue(':Data_Entrada', $_POST['Data_Entrada'], PDO::PARAM_STR);                $stmt->bindValue(':Data_Saida', $_POST['Data_Saida'], PDO::PARAM_STR);                $stmt->bindValue(':Cargo', $_POST['Cargo'], PDO::PARAM_STR);                $stmt->bindValue(':Emprego_Atual', $_POST['Emprego_Atual'], PDO::PARAM_INT);                $stmt->bindValue(':Atividades_Desenvolvidas', $_POST['Atividades_Desenvolvidas'], PDO::PARAM_STR);                $stmt->bindValue(':Id', $_POST['IdExperiencia'], PDO::PARAM_INT);                $stmt->bindValue(':IdCandidato', $_POST['IdCandidato'], PDO::PARAM_INT);                                $stmt->execute();                                $r = $stmt->rowCount();                                $ExperienciaAtualizada = $this->selecionarUmaExperiencia($_POST['IdCandidato'], $_POST['IdExperiencia']);                                if($r > 0 ){                    $retorno = array("sucesso" => "Experiencia atualizada", "informacoes" => $ExperienciaAtualizada['sucesso'][0]);                } else {                    $retorno = array("erro" => "Erro ao atualizar experiencia");                }                                return $retorno;                            } catch (PDOException $exc) {                echo "Erro: Nao consegui atualizar experiencia profissional" . $exc->getTraceAsString();            }        }        public function __destruct() {        $this->bd = null;    }}?>