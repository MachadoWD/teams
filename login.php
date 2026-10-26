<?php
require_once __DIR__ . '/includes/funcoes.php';

if (usuario_logado()) {
    redirecionar('index.php');
}

$erro = '';
$loginDigitado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginDigitado = trim($_POST['login'] ?? '');
    $senha         = $_POST['senha'] ?? '';

    if (!csrf_valido()) {
        $erro = 'Sessão expirada. Recarregue a página e tente novamente.';
    } elseif ($loginDigitado === '' || $senha === '') {
        $erro = 'É necessário digitar usuário e senha para prosseguir.';
    } else {
        try {
            $stmt = conectar()->prepare('SELECT id, nome, login, senha_hash FROM usuarios WHERE login = ?');
            $stmt->execute([$loginDigitado]);
            $usuario = $stmt->fetch();

            if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
                // Sucesso: cria a sessão
                session_regenerate_id(true);
                $_SESSION['usuario_id']    = (int)$usuario['id'];
                $_SESSION['usuario_nome']  = $usuario['nome'];
                $_SESSION['usuario_login'] = $usuario['login'];

                definir_flash('sucesso', 'Login realizado com sucesso! Bem-vindo(a), ' . $usuario['nome'] . '.');
                redirecionar('index.php');
            }
            // Mensagem genérica: não revela se foi o usuário ou a senha que errou
            $erro = 'Falha no login: usuário ou senha incorretos.';
        } catch (PDOException $e) {
            $erro = 'Erro ao acessar o banco de dados. Tente novamente mais tarde.';
        }
    }
}

$titulo = 'Login';
include __DIR__ . '/includes/header.php';
?>
    <main class="main-log">
        <form action="login.php" method="post" class="login">
            <div class="center">
                <h2>Login</h2>
            </div>
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

            <label for="login">Login:</label>
            <input id="login" name="login" type="text" placeholder="Digite seu Login" value="<?= e($loginDigitado) ?>">

            <label for="senha">Senha:</label>
            <input id="senha" name="senha" type="password" placeholder="Digite sua Senha">

            <?php if ($erro): ?>
                <div class="mensagem-erro"><p><?= e($erro) ?></p></div>
            <?php endif; ?>

            <div class="center ">
                <button id="enviar" type="submit" class="botao_enviar">Enviar</button>
                <button type="reset" class="botao_apagar">Apagar</button>
                <a href="cadastro.php">Ainda não fez cadastro em nosso site? <u>Cadastre-se</u></a>
            </div>
        </form>
    </main>
<?php include __DIR__ . '/includes/footer.php'; ?>
