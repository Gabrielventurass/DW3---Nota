<?php
require_once("../Classes/Nota.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = isset($_POST['id'])?$_POST['id']:0;
    $trimestre = isset($_POST['trimestre'])?$_POST['trimestre']:"";
    $descricao = isset($_POST['descricao'])?$_POST['descricao']:0;
    $valor = isset($_POST['valor'])?$_POST['valor']:0;
    $datalancada = isset($_POST['datalancada'])?$_POST['datalancada']:0;
    $anexo = isset($_POST['anexo'])?$_POST['anexo']:0;
    $acao = isset($_POST['acao'])?$_POST['acao']:"";

    $destino_anexo = 'uploads/'.$_FILES['anexo']['name'];
    move_uploaded_file($_FILES['anexo']['tmp_name'],PATH_UPLOAD.$destino_anexo);

    $nota = new Nota($id,$trimestre,$descricao,$valor,$datalancada,$destino_anexo);
    if ($acao == 'salvar')
        if ($id > 0)
            $resultado = $nota->alterar();
        else
            $resultado = $nota->inserir();
    elseif ($acao == 'excluir')
        $resultado = $nota->excluir();

    if ($resultado)
        header("Location: index.php");
    else
        echo "Erro ao salvar dados: ". $nota;
}elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $formulario = file_get_contents('form_cad_nota.html');

    $id = isset($_GET['id'])?$_GET['id']:0;
    $resultado = Nota::listar(1,$id);
    if ($resultado){
        $nota = $resultado[0];
        $formulario = str_replace('{id}',$nota->getId(),$formulario);
        $formulario = str_replace('{trimestre}',$nota->getTrimestre(),$formulario);
        $formulario = str_replace('{descricao}',$nota->getDescricao(),$formulario);
        $formulario = str_replace('{valor}',$nota->getValor(),$formulario);
        $formulario = str_replace('{datalancada}',$nota->getDatalancada(),$formulario);
        $formulario = str_replace('{anexo}',$nota->getAnexo(),$formulario);
    }else{
        $formulario = str_replace('{id}',0,$formulario);
        $formulario = str_replace('{trimestre}','',$formulario);
        $formulario = str_replace('{descricao}','',$formulario);
        $formulario = str_replace('{valor}','',$formulario);
        $formulario = str_replace('{datalancada}','',$formulario);
        $formulario = str_replace('{anexo}','',$formulario);
    }
    print($formulario); 
    include_once('lista_nota.php');
 

}
?>