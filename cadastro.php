<?php
require_once __DIR__ . '/includes/funcoes.php';

if (usuario_logado()) {
    redirecionar('index.php');
}

$erros = [];
$valores = ['nome' => '', 'login' => '', 'cpf' => '', 'data' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valido()) {
        $erros[] = 'Sessão expirada. Recarregue a página e tente novamente.';
    }

    $valores['nome']  = trim($_POST['nome'] ?? '');
    $valores['login'] = trim($_POST['login'] ?? '');
    $valores['cpf']   = trim($_POST['cpf'] ?? '');
    $valores['data']  = trim($_POST['data'] ?? '');
    $valores['email'] = trim($_POST['email'] ?? '');
    $senha            = $_POST['senha'] ?? '';
    $cpfNumeros       = preg_replace('/\D/', '', $valores['cpf']);

    // --- Validações no servidor ---
    if ($valores['nome'] === '' || mb_strlen($valores['nome']) > 100) {
        $erros[] = 'Informe o nome (até 100 caracteres).';
    }
    if (!preg_match('/^[A-Za-z0-9_.]{3,30}$/', $valores['login'])) {
        $erros[] = 'O login deve ter de 3 a 30 caracteres (letras, números, "_" ou ".").';
    }
    if (strlen($senha) < 6) {
        $erros[] = 'A senha deve ter pelo menos 6 caracteres.';
    }
    if (!cpf_valido($cpfNumeros)) {
        $erros[] = 'CPF inválido.';
    }
    $dataObj = DateTime::createFromFormat('Y-m-d', $valores['data']);
    if (!$dataObj || $dataObj->format('Y-m-d') !== $valores['data'] || $dataObj > new DateTime('today')) {
        $erros[] = 'Data de nascimento inválida.';
    }
    if (!filter_var($valores['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($valores['email']) > 100) {
        $erros[] = 'E-mail inválido.';
    }

    // --- Grava no banco ---
    if (!$erros) {
        try {
            $pdo = conectar();

            $stmt = $pdo->prepare('SELECT login, cpf, email FROM usuarios WHERE login = ? OR cpf = ? OR email = ?');
            $stmt->execute([$valores['login'], $cpfNumeros, $valores['email']]);
            foreach ($stmt->fetchAll() as $existente) {
                if (strcasecmp($existente['login'], $valores['login']) === 0) {
                    $erros[] = 'Este login já está em uso.';
                }
                if ($existente['cpf'] === $cpfNumeros) {
                    $erros[] = 'Este CPF já está cadastrado.';
                }
                if (strcasecmp($existente['email'], $valores['email']) === 0) {
                    $erros[] = 'Este e-mail já está cadastrado.';
                }
            }
            $erros = array_values(array_unique($erros));

            if (!$erros) {
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $ins = $pdo->prepare(
                    'INSERT INTO usuarios (nome, login, senha_hash, cpf, data_nascimento, email)
                     VALUES (?, ?, ?, ?, ?, ?)'
                );
                $ins->execute([
                    $valores['nome'], $valores['login'], $hash,
                    $cpfNumeros, $valores['data'], $valores['email'],
                ]);

                definir_flash('sucesso', 'Cadastro realizado com sucesso! Faça login para continuar.');
                redirecionar('login.php');
            }
        } catch (PDOException $e) {
            // 23000 = violação de chave única (corrida entre dois cadastros iguais)
            $erros[] = $e->getCode() === '23000'
                ? 'Login, CPF ou e-mail já cadastrado.'
                : 'Erro ao salvar o cadastro. Tente novamente mais tarde.';
        }
    }
}

$titulo = 'Cadastro';
include __DIR__ . '/includes/header.php';
?>
    <main>
        <form action="cadastro.php" method="post" class="cadastro" novalidate>
            <h2>Cadastro de Usúario</h2>
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

            <?php foreach ($erros as $erro): ?>
                <div class="mensagem-erro"><p><?= e($erro) ?></p></div>
            <?php endforeach; ?>

            <label for="nome">Nome:</label>
            <input id="nome" name="nome" type="text" placeholder="Digite seu Nome" maxlength="100" value="<?= e($valores['nome']) ?>">

            <label for="login">Login:</label>
            <input id="login" name="login" type="text" placeholder="Digite seu Login" maxlength="30" value="<?= e($valores['login']) ?>">

            <label for="senha">Senha:</label>
            <input id="senha" name="senha" type="password" placeholder="Digite sua Senha">

            <label for="cpf">CPF:</label>
            <input id="cpf" name="cpf" type="text" placeholder="Digite seu CPF" maxlength="14" value="<?= e($valores['cpf']) ?>">

            <label for="data">Data de Nascimento:</label>
            <input id="data" name="data" type="date" max="<?= date('Y-m-d') ?>" value="<?= e($valores['data']) ?>">

            <label for="email">E-Mail:</label>
            <input id="email" name="email" type="email" placeholder="Digite seu E-Mail" maxlength="100" value="<?= e($valores['email']) ?>">

            <div class="center">
                <button id="enviar-cadastro" type="submit" class="botao_enviar">Enviar</button>
                <button type="reset" class="botao_apagar">Apagar</button>
                <a href="login.php">Já possui uma conta? <u>Faça o login</u></a>
            </div>
        </form>
    </main>
<?php include __DIR__ . '/includes/footer.php'; ?>
