<?php
// Inclua este arquivo no INÍCIO de qualquer página que exija login.
require_once __DIR__ . '/funcoes.php';

if (!usuario_logado()) {
    definir_flash('erro', 'Você precisa estar logado para acessar esta página.');
    redirecionar('login.php');
}
