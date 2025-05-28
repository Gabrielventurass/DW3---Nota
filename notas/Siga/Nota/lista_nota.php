<?php
    require_once("../Classes/Nota.class.php");
    $busca = isset($_GET['busca'])?$_GET['busca']:0;
    $tipo = isset($_GET['tipo'])?$_GET['tipo']:0;
   
    $lista = Nota::listar($tipo, $busca);
    $itens = '';
    foreach($lista as $nota){
        $item = file_get_contents('itens_listagem_notas.html');
        $item = str_replace('{id}',$nota->getId(),$item);
        $item = str_replace('{trimestre}',$nota->getTrimestre(),$item);
        $item = str_replace('{descricao}',$nota->getDescricao(),$item);
        $item = str_replace('{valor}',$nota->getValor(),$item);
        $item = str_replace('{datalancada}',$nota->getDatalancada(),$item);
        $item = str_replace('{anexo}',PATH_UPLOAD.$nota->getAnexo(),$item);
        $itens .= $item;
    }
    $listagem = file_get_contents('listagem_nota.html');
    $listagem = str_replace('{itens}',$itens,$listagem);
    print($listagem);
     
?>