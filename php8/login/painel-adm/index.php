<?php

require_once('../../conexao.php');
@session_start();

// Verificar Se o Usuário Logado é um Administrador
if (@$_SESSION['nivel_usuario'] != 'Administrador') {
    echo "<script language='javascript'>window.location='../index.php'</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Administrador</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Usuários</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sair
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#"><?php echo $_SESSION['nome_usuario'] ?></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../logout.php">Sair</a></li>
          </ul>
        </li>
      </ul>
      <form method="GET" class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Buscar" name="txtBuscar">
        <button class="btn btn-outline-secondary" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>

<div class="container">
  <a href="index.php?funcao=novo" class="btn btn-secondary mt-4" type="button">Novo Usuário</a>

  <table class="table table-stripped mt-4">
    <thead>
      <tr>
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
        <th scope="col">Senha</th>
        <th scope="col">Nível</th>
        <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $txtBuscar = '%' . @$_GET['txtBuscar'] . '%';    
      $query = $pdo->prepare("SELECT * FROM usuarios WHERE nome LIKE :nome OR email LIKE :email");
      $query->bindValue(":nome", $txtBuscar);
      $query->bindValue(":email", $txtBuscar);
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
      $total_reg = @count($res);

      if ($total_reg > 0) {
        foreach ($res as $usuario) {
          $nome = $usuario['nome'];
          $email = $usuario['email'];
          $senha = $usuario['senha'];
          $nivel = $usuario['nivel'];
          $id = $usuario['id'];
      ?>
      <tr>
        <td><?php echo htmlspecialchars($nome); ?></td>
        <td><?php echo htmlspecialchars($email); ?></td>
        <td><?php echo htmlspecialchars($senha); ?></td>
        <td><?php echo htmlspecialchars($nivel); ?></td>
        <td> 
          <a href="index.php?funcao=editar&id=<?php echo $id; ?>" title="Editar Registro" class="mr-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square text-info" viewBox="0 0 16 16">
              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
            </svg>
          </a>

          <a href="#" data-id="<?php echo $id; ?>" class="text-danger" data-bs-toggle="modal" data-bs-target="#modalDeletar" title="Deletar Registro">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
              <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
            </svg>
          </a>
        </td>
      </tr>
      <?php
        }
      } else {
        echo '<tr><td colspan="5" class="text-center mt-4">Não há dados para ser exibidos!</td></tr>';
      }
      ?>
    </tbody>
  </table>
</div>

<!-- Modal para Inserir/Editar Usuário -->
<div class="modal fade" id="modalCadastrar" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <?php
        if (@$_GET['funcao'] == 'editar') {
          $titulo_modal = "Editar Registro";
          $botao_modal = "btn-editar";
          $query = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
          $query->bindValue(":id", $_GET['id']);
          $query->execute();
          $res = $query->fetch(PDO::FETCH_ASSOC);
          $nome_ed = $res['nome'];
          $email_ed = $res['email'];
          $senha_ed = $res['senha'];
          $nivel_ed = $res['nivel'];
        } else {
          $titulo_modal = "Novo Registro";
          $botao_modal = "btn-salvar";
          $nome_ed = "";
          $email_ed = "";
          $senha_ed = "";
          $nivel_ed = "";
        }
        ?>
        <h5 class="modal-title"><?php echo $titulo_modal; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="index.php">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($nome_ed); ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email_ed); ?>" required>
          </div>
          <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" value="<?php echo htmlspecialchars($senha_ed); ?>" required>
          </div>
          <div class="mb-3">
            <label for="nivel" class="form-label">Nível</label>
            <select class="form-select" id="nivel" name="nivel" required>
              <option value="Administrador" <?php echo $nivel_ed == 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
              <option value="Usuário" <?php echo $nivel_ed == 'Usuário' ? 'selected' : ''; ?>>Usuário</option>
            </select>
          </div>
          <input type="hidden" name="id" value="<?php echo @$_GET['id']; ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary" name="<?php echo $botao_modal; ?>">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para Exclusão -->
<div class="modal fade" id="modalDeletar" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Deletar Usuário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="index.php">
        <div class="modal-body">
          <p>Você quer mesmo deletar esse usuário?</p>
          <input type="hidden" name="id" id="idDeletar">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-danger" name="btn-deletar">Excluir</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  
  if (urlParams.get('funcao') === 'novo' || urlParams.get('funcao') === 'editar') {
    new bootstrap.Modal(document.getElementById('modalCadastrar')).show();
  }

  // Mostrar modal de exclusão
  if (urlParams.get('funcao') === 'deletar') {
    const idDeletar = urlParams.get('id');
    document.getElementById('idDeletar').value = idDeletar;
    new bootstrap.Modal(document.getElementById('modalDeletar')).show();
  }

  // Set ID for delete action
  document.querySelectorAll('a[data-id]').forEach(element => {
    element.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      document.getElementById('idDeletar').value = id;
    });
  });
});
</script>

<?php
if (isset($_POST['btn-salvar']) || isset($_POST['btn-editar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];
    $id = $_POST['id'] ?? null;

    if (empty($id)) {
        $query = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, nivel) VALUES (:nome, :email, :senha, :nivel)");
        $query->bindValue(":nome", $nome);
        $query->bindValue(":email", $email);
        $query->bindValue(":senha", $senha);
        $query->bindValue(":nivel", $nivel);
        $query->execute();
        echo "<script language='javascript'>window.alert('Usuário cadastrado com sucesso!')</script>";
    } else {
        $query = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, nivel = :nivel WHERE id = :id");
        $query->bindValue(":nome", $nome);
        $query->bindValue(":email", $email);
        $query->bindValue(":senha", $senha);
        $query->bindValue(":nivel", $nivel);
        $query->bindValue(":id", $id);
        $query->execute();
        echo "<script language='javascript'>window.alert('Usuário atualizado com sucesso!')</script>";
    }
    echo "<script language='javascript'>window.location='index.php'</script>";
    exit();
}

if (isset($_POST['btn-deletar'])) {
    if (!empty($_POST['id'])) {
        $query = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $query->bindValue(":id", $_POST['id']);
        $query->execute();
        echo "<script language='javascript'>window.alert('Usuário excluído com sucesso!')</script>";
        echo "<script language='javascript'>window.location='index.php'</script>";
        exit();
    }
}
?>
</body>
</html>
