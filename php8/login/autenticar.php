<?php

require_once('../conexao.php');
@session_start();

$email = $_POST['email'];
$senha = $_POST['senha'];

$query = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
    $query->bindValue(":email", $email);
    $query->bindValue(":senha", $senha);
    $query->execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = count($res);

if($total_reg > 0){

    // Criar as Variáveis de Sessão
    $_SESSION['nome_usuario'] = $res[0]['nome'];
    $nivel = $res[0]['nivel'];
    $_SESSION['nivel_usuario'] = $res[0]['nivel'];

    if($nivel == 'Administrador'){
    echo "<script language='javascript'>window.location='painel-adm'</script>";
 } else if($nivel == 'Cliente') {
    echo "<script language='javascript'>window.location='painel-cliente'</script>";
 } else {
    echo "<script language='javascript'>window.alert('Usuário sem permissão para acesso')</script>";
    echo "<script language='javascript'>window.location='index.php'</script>";
 }

} else {
    echo "<script language='javascript'>window.alert('Dados incorretos!')</script>";
    echo "<script language='javascript'>window.location='index.php'</script>";
}

?>
