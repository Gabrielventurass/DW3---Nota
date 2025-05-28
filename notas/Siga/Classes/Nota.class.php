<?php
require_once ("Database.class.php");
class Nota{
    private $id;
    private $trimestre;
    private $descricao;
    private $valor;
    private $datalancada;
    private $anexo;

    // construtor da classe
    public function __construct($id,$trimestre,$descricao,$valor,$datalancada,$anexo){
        $this->setId($id);
        $this->setTrimestre($trimestre);
        $this->setDescricao($descricao);
        $this->setValor($valor);
        $this->setDatalancada($datalancada);
        $this->setAnexo($anexo);
    }

    public function setId($id){
        if ($id < 0)
            throw new Exception('Erro. O ID deve ser maior ou igual a 0');
        else
            $this->id = $id;
    }

    public function setTrimestre($trimestre){
        if ($trimestre < 0)
            throw new Exception('Erro. Informe o trimestre.');
        else
            $this->trimestre = $trimestre;
    }

    public function setDescricao($descricao){
        if ($descricao == "") // regras para descrição
            throw new Exception('Erro. Informe uma descrição.');
        else
            $this->descricao = $descricao;
    }

    public function setValor($valor){
        if ($valor < 0) // regras para valor
            throw new Exception('Erro. Informe um valor válida.');
        else
            $this->valor = $valor;
    }

    public function setDatalancada($datalancada){
        if ($datalancada == "") // regras para data
            throw new Exception('Erro. Informe uma data válida.');
        else
            $this->datalancada = $datalancada;
    }

    public function setAnexo($anexo){
        if ($anexo == "") // regras para anexo
            throw new Exception('Erro. Informe um anexo válido.');
        else
            $this->anexo = $anexo;
    }

    public function getId(){return $this->id;}
    public function getTrimestre(){return $this->trimestre;}
    public function getDescricao(){return $this->descricao;}
    public function getValor(){return $this->valor;}
    public function getDatalancada(){return $this->datalancada;}
    public function getAnexo(){return $this->anexo;}

    // método mágico para imprimir uma atividade
    public function __toString():String{  
        $str = "Nota: $this->getId() - $this->getTrimestre() - $this->getDescricao()";        
        return $str;
    }

    // insere uma atividade no banco 
    public function inserir():Bool{
        // montar o sql/ query
        $sql = "INSERT INTO nota 
                    (trimestre, descricao, valor, datalancada, anexo)
                    VALUES(:trimestre, :descricao, :valor, :datalancada, :anexo)";
        
        $parametros = array(':trimestre'=>$this->getTrimestre(),
                            ':descricao'=>$this->getDescricao(),
                            ':valor'=>$this->getValor(),
                            ':datalancada'=>$this->getDatalancada(),
                            ':anexo'=>$this->getAnexo());
        
        return Database::executar($sql, $parametros) == true;
    }

    public static function listar($tipo=0, $info=''):Array{
        $sql = "SELECT * FROM nota";
        switch ($tipo){
            case 0: break;
            case 1: $sql .= " WHERE id = :info ORDER BY id"; break; // filtro por ID
            case 2: $sql .= " WHERE trimestre like :info ORDER BY trimestre"; $info = '%'.$info.'%'; break; // filtro por trimestre
            case 3: $sql .= " WHERE descricao = :info ORDER BY descricao"; break; // filtro por descricao
            case 4: $sql .= " WHERE valor = :info ORDER BY valor"; break; // filtro por valor
            case 5: $sql .= " WHERE datalancada = :info ORDER BY datalancada"; break; // filtro por data lançada
            case 6: $sql .= " WHERE anexo = :info ORDER BY anexo"; break; // filtro por anexo
        }
        $parametros = array();
        if ($tipo > 0)
            $parametros = [':info'=>$info];

        $comando = Database::executar($sql, $parametros);
        $notas = [];
        while ($registro = $comando->fetch()){
            $nota = new Nota($registro['id'],$registro['trimestre'],$registro['descricao'],$registro['valor'],$registro['datalancada'],$registro['anexo']);
            array_push($notas,$nota);
        }
        return $notas;
    }

    public function alterar():Bool{       
       $sql = "UPDATE nota
                  SET trimestre = :trimestre, 
                      descricao = :descricao,
                      valor = :valor,
                      datalancada = :datalancada,
                      anexo = :anexo
                WHERE id = :id";
         $parametros = array(':id'=>$this->getId(),
                        ':trimestre'=>$this->getTrimestre(),
                        ':descricao'=>$this->getDescricao(),
                        ':valor'=>$this->getValor(),
                        ':datalancada'=>$this->getDatalancada(),
                        ':anexo'=>$this->getAnexo());
        return Database::executar($sql, $parametros) == true;
    }

    public function excluir():Bool{
        $sql = "DELETE FROM nota
                      WHERE id = :id";
        $parametros = array(':id'=>$this->getid());
        return Database::executar($sql, $parametros) == true;
     }
}


?>