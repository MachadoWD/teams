<?php
// Página protegida: só acessível para usuários logados.
require_once __DIR__ . '/includes/protegido.php';

$titulo = 'Teams - Carrinho';
include __DIR__ . '/includes/header.php';
?>
    <main class="main-carrinho">
        <div class="carrinho">
            <h1> Seu Carrinho</h1>
            <p>Olá, <?= e($_SESSION['usuario_nome']) ?>! (<a href="logout.php"><u>Sair</u></a>)</p>
            <div class="conteudo">
            <div class="c-jogos">
                <div class="c-jogo">
                    <a href="jogo.html"><img class="c-img-jogo" src="img/inscryption.jpg" alt="Imagem de Inscryption"></a>
                    <div class="info">
                        <h2>Inscryption</h2>
                        <h3>R$49,99</h3>
                        <p>Unidades: <span><input onchange="atualizarTotal(), atualizarTotalJogo(1)" id="qnt1" type="number" min="0" value="1" class="quantidade"></span></p>
                    </div>      

                    <div class="escolhas">  
                        <p id="total1"><strong>Total: R$49,99</strong></p>
                        <button>Remover</button>
                    </div>
                </div>
                <div class="c-jogo">
                    <a href="jogo.html"><img class="c-img-jogo" src="img/hotline.jpg" alt="Imagem de Hotline Miami"></a>
                    <div class="info">
                        <h2>Hotline Miami</h2>
                        <h3>R$32,99</h3>
                        <p>Unidades: <span><input onchange="atualizarTotal(), atualizarTotalJogo(2)" id="qnt2" type="number" min="0" value="1" class="quantidade"></span></p>
                    </div>    

                    <div class="escolhas">  
                        <p id="total2"><strong>Total: R$32,99</strong></p>
                        <button>Remover</button>
                    </div>
                </div>
                <div class="c-jogo">
                    <a href="jogo.html"><img class="c-img-jogo" src="img/disco.jpg" alt="Imagem de Disco Elysium"></a>
                    <div class="info">
                        <h2>Disco Elysium</h2>
                        <h3>R$75,49</h3>
                        <p>Unidades: <span><input onchange="atualizarTotal(), atualizarTotalJogo(3)" id="qnt3" type="number" min="0" value="1" class="quantidade"></span></p>
                    </div>      

                    <div class="escolhas">  
                        <p id="total3"><strong>Total: R$75,49</strong></p>
                        <button>Remover</button>
                    </div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 2vh;">
                <div class="pagamento">
                    <div class="total">
                        <h1>Total Estimado:</h1> 
                        <h1 id="total">R$158,47</h1> 
                        <h2 id="frete">+ frete</h2>
                    </div>
                    <!-- <p>O imposto sobre vendas será calculado durante a finalização da compra, onde aplicável.</p> -->
                    <a href="pagamento.html" class="pagar botao_enviar"><p>Continuar Para o Pagamento</p></a>
                </div>
                <div class="pagamento">
                    <div class="total">
                        <input type="number" placeholder="CEP" class="cep" id="cep" min="0">
                    </div> 
                    <button class="pagar botao_enviar" onclick="calcularFrete()" style="font-size: 1vw;">Calcular Frete</button>
                </div>
        
                <div class="pagamento">
                    <h3>Cupom de Desconto</h3>
                    <div class="total" style="margin-top: 3%;">
                        <input type="text" placeholder="Digite o código do cupom" class="cep" id="cupom">
                    </div>
                    <button class="pagar botao_enviar" onclick="aplicarCupom()" style="font-size: 1vw;">Aplicar Cupom</button>
                </div>
            </div>
            </div>
        </div>
    </main>
<?php include __DIR__ . '/includes/footer.php'; ?>
