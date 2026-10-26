<?php
require_once __DIR__ . '/includes/funcoes.php';

$titulo = 'Teams';

// Busca os produtos cadastrados no banco de dados
try {
    $produtos = conectar()->query('SELECT id, nome, preco, imagem FROM produtos ORDER BY id')->fetchAll();
} catch (PDOException $e) {
    $produtos = [];
    $erroProdutos = 'Não foi possível carregar os produtos no momento.';
}

include __DIR__ . '/includes/header.php';
?>
    <main>
        <?php if (!empty($erroProdutos)): ?>
            <p class="mensagem-erro"><?= e($erroProdutos) ?></p>
        <?php elseif (!$produtos): ?>
            <p>Nenhum produto cadastrado.</p>
        <?php endif; ?>

        <div class="jogos">
            <?php foreach ($produtos as $p): ?>
            <article class="jogo color13">
                <a href="jogo.html"><img src="<?= e($p['imagem']) ?>" alt="Capa de <?= e($p['nome']) ?>" class="img-jogo"></a>
                <h2><?= e($p['nome']) ?></h2>
                <div class="legenda">
                    <div>
                        <button class="botao_apagar">Adicionar ao Carrinho</button>
                        <button class="botao_enviar">Comprar</button>
                    </div>
                    <p class="preco"><?= e(formatar_preco((float)$p['preco'])) ?></p>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </main>
<?php include __DIR__ . '/includes/footer.php'; ?>
