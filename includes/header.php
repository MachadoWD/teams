<?php
// Cabeçalho comum. Defina $titulo (e opcionalmente $classeBody) antes de incluir.
require_once __DIR__ . '/funcoes.php';
$titulo     = $titulo ?? 'Teams';
$classeBody = $classeBody ?? 'color10';
$flash      = obter_flash();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title><?= e($titulo) ?></title>
</head>
<body class="<?= e($classeBody) ?>">
    <!--loja virtual de jogos digitais -->
    <header class="header">

        <div class="logo">
            <img id="logo" src="img/logo.png" alt="Logo do Teams">
            <nav class="nav1">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Sobre</a></li>
                    <li><a href="#">Comunidade</a></li>
                    <?php if (usuario_logado()): ?>
                        <li><a href="logout.php">Sair</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Entrar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <a href="carrinho.php"><img src="img/carrinho.png" alt="Carrinho de Compras" id="carrinho"></a>
        </div>

        <div class="search-bar">
            <nav class="cat">
                <ul class="nav-links2">
                    <li class="dropdown">
                        Categorias
                        <ul class="submenu">
                            <li>Investigação</li>
                            <li>Shooter</li>
                            <li>RPG</li>
                            <li>Indie</li>
                            <li>Roguelike</li>
                        </ul>
                    </li>
                    <li>Explorar</li>
                    <li>Recomendações</li>
                    <li><a href="wishlist.html">Wishlist</a></li>
                </ul>
            </nav>

            <form>
                <input type="text" id="input" list="opcoes" placeholder="Digite sua busca...">
                <datalist id="opcoes"></datalist>
                <button type="submit">Pesquisar</button>
            </form>
        </div>

    </header>
    <?php if ($flash): ?>
        <div class="flash flash-<?= e($flash['tipo']) ?>" role="alert">
            <p><?= e($flash['mensagem']) ?></p>
        </div>
    <?php endif; ?>
