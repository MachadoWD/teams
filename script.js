document.addEventListener("DOMContentLoaded", () => {
    const jogos = ["Pathologic 2", "Red Dead Redemption 2", "Dead Cells", "Portal", "Hollow Knight", "Obra Dinn", "Blue Prince", "Deep Rock Galatic", "Stardew Valley"];
    if (!document.getElementById("input")) {
        return;
    }
    const input = document.getElementById("input");
    const datalist = document.getElementById("opcoes");

    input.addEventListener("input", () => {
        datalist.innerHTML = "";
        const textoDigitado = input.value.toLowerCase().trim();

        if (textoDigitado.length < 1) {
            return;
        }

        jogos.forEach(item => {
            const nomeJogo = item.toLowerCase();
            if (nomeJogo.startsWith(textoDigitado)) {
                const opcao = document.createElement("option");
                opcao.value = item;
                datalist.appendChild(opcao);
            }
        });
    });
});

// ---------- Validação no navegador (login e cadastro) ----------
// A validação definitiva é feita no servidor (PHP); aqui só evitamos envios vazios.
function mostrarErros(form, mensagens) {
    form.querySelectorAll(".mensagem-erro.js").forEach(el => el.remove());
    mensagens.forEach(texto => {
        const caixa = document.createElement("div");
        caixa.classList.add("mensagem-erro", "js");
        const p = document.createElement("p");
        p.textContent = texto;
        caixa.appendChild(p);
        form.insertBefore(caixa, form.querySelector(".center:last-child") || null);
    });
}

if (document.getElementById("enviar")) {
    const form = document.querySelector(".login");

    form.addEventListener("submit", (event) => {
        const erros = [];
        if (form.login.value.trim() === "" || form.senha.value.trim() === "") {
            erros.push("É necessário digitar usuário e senha para prosseguir.");
        }
        if (erros.length > 0) {
            event.preventDefault();
            mostrarErros(form, erros);
        }
    });
}

if (document.getElementById("enviar-cadastro")) {
    const form = document.querySelector(".cadastro");

    form.addEventListener("submit", (event) => {
        const campos = [
            ["nome", "É necessário digitar o nome"],
            ["login", "É necessário digitar o login"],
            ["senha", "É necessário digitar a senha"],
            ["cpf", "É necessário digitar o cpf"],
            ["data", "É necessário digitar a data de nascimento"],
            ["email", "É necessário digitar o email"]
        ];
        const erros = campos
            .filter(([nome]) => form.elements[nome].value.trim() === "")
            .map(([, mensagem]) => mensagem);

        if (form.senha.value !== "" && form.senha.value.length < 6) {
            erros.push("A senha deve ter pelo menos 6 caracteres.");
        }

        if (erros.length > 0) {
            event.preventDefault();
            mostrarErros(form, erros);
        }
    });
}

if (document.getElementById("adicionar")) {
    const adicionar = document.getElementById("adicionar");
    const totalP = document.getElementById("total");
    let total = 0;
    const reduzir = document.getElementById("reduzir");
    const qnt = document.getElementById("qnt");
    let quantidade = 0;
    adicionar.addEventListener("click", adicionarJogo);
    reduzir.addEventListener("click", reduzirJogo);

    function adicionarJogo() {
        quantidade += 1
        qnt.textContent = `Quantidade: ${quantidade}`;
        calcularTotal();
    }
    function reduzirJogo() {
        if (quantidade > 0) {
            quantidade -= 1
        }
        qnt.textContent = `Quantidade: ${quantidade}`;
        calcularTotal();
    }
    function calcularTotal() {
        totalP.textContent = `Total: R$${(quantidade * 59.99).toFixed(2).replace(".", ",")}`;
    }
}

function atualizarTotalJogo(value) {
    const qnt1 = parseInt(document.getElementById("qnt1").value);
    const qnt2 = parseInt(document.getElementById("qnt2").value);
    const qnt3 = parseInt(document.getElementById("qnt3").value);   

    const totalJogo = document.getElementById("totalJogo");

    switch (value) {
        case 1:
            const total1 = (qnt1 * 49.99).toFixed(2).replace(".", ",");
            document.getElementById("total1").textContent = `Total: R$${total1}`;
            break;
        case 2:
            const total2 = (qnt2 * 32.99).toFixed(2).replace(".", ",");
            document.getElementById("total2").textContent = `Total: R$${total2}`;
            break;
        case 3:
            const total3 = (qnt3 * 75.49).toFixed(2).replace(".", ",");
            document.getElementById("total3").textContent = `Total: R$${total3}`;
            break;

    }
}

function atualizarTotal() {
    const qnt1 = parseInt(document.getElementById("qnt1").value);
    const qnt2 = parseInt(document.getElementById("qnt2").value);
    const qnt3 = parseInt(document.getElementById("qnt3").value);   

    const preco1 = 49.99;
    const preco2 = 32.99;
    const preco3 = 75.49;

    const total = (qnt1 * preco1) + (qnt2 * preco2) + (qnt3 * preco3);
    document.getElementById("total").textContent = `R$${total.toFixed(2).replace(".", ",")}`;

}


function calcularFrete(){
    const cep = document.getElementById("cep").value;

    if (cep.length === 8) {
        if (cep == "88495000") {
            document.getElementById("frete").textContent = "+ R$10,00 frete";
        }
        else if (cep == "88780000") {
            document.getElementById("frete").textContent = "+ R$15,00 frete";
        }
        else if (cep == "88490000") {
            document.getElementById("frete").textContent = "+ R$2000,00 frete";
        }
    }
}

let cupomDescontoAplicado = 0;
let cupomFreteAplicado = 0;
function aplicarCupom() {
    const cupom = document.getElementById("cupom").value;
    const totalElement = document.getElementById("total");
    let total = parseFloat(totalElement.textContent.replace("R$", "").replace(",", "."));

    
    if (cupom === "INFO24" && cupomDescontoAplicado === 0) {
        total *= 0.76; // Aplica desconto de 24%
        totalElement.textContent = `R$${total.toFixed(2).replace(".", ",")}`;
        cupomDescontoAplicado = 1;
    } else if (cupom === "CASADOEDU" && cupomFreteAplicado === 0) {
        const freteElement = document.getElementById("frete");
        freteElement.textContent = "+ R$0,00 frete";
        cupomFreteAplicado = 1;
    }

}
