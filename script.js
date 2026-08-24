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

if (document.getElementById("enviar")) {
    let loginInput = document.getElementById("login");
    let senhaInput = document.getElementById("senha");
    let enviar = document.getElementById("enviar");
    let form = document.querySelector(".login");

    enviar.addEventListener("click", (event) => {
        event.preventDefault();
        logar(loginInput.value, senhaInput.value);
    });

    function logar(login, senha) {
        const erroAntigo = document.querySelector(".mensagem-erro");
        if (erroAntigo) {
            erroAntigo.remove();
        }

        if (login.trim() === "" || senha.trim() === "") {
            const erroLogin = document.createElement("div");
            erroLogin.classList.add("mensagem-erro");
            let erro = document.createElement("p");
            erro.style.color = 'rgb(167, 6, 6)';
            erro.textContent = "É necessário digitar usuário e senha para prosseguir.";
            erroLogin.appendChild(erro);
            form.appendChild(erroLogin);
        }
    }
}

if (document.getElementById("enviar-cadastro")) {
    let loginInput = document.getElementById("login");
    let senhaInput = document.getElementById("senha");
    let nomeInput = document.getElementById("nome");
    let cpfInput = document.getElementById("cpf");
    let emailInput = document.getElementById("email");
    let dataInput = document.getElementById("data");
    let enviar = document.getElementById("enviar-cadastro");
    let form = document.querySelector(".cadastro");

    enviar.addEventListener("click", (event) => {
        event.preventDefault();
        logar(loginInput.value, senhaInput.value, nomeInput.value, cpfInput.value, emailInput.value, dataInput.value);
    });

    function logar(login, senha, nome, cpf, email, data) {
        const errosAntigos = document.querySelectorAll(".mensagem-erro");
        errosAntigos.forEach(erro => erro.remove())

        if (login.trim() === "") {
            const erroLogin = document.createElement("div");
            erroLogin.classList.add("mensagem-erro");
            let erro = document.createElement("p");
            erro.style.color = 'rgb(167, 6, 6)';
            erro.textContent = "É necessário digitar o login";
            erroLogin.appendChild(erro);
            form.appendChild(erroLogin);
        }
        if (senha.trim() === "") {
            const erroLogin = document.createElement("div");
            erroLogin.classList.add("mensagem-erro");
            let erro = document.createElement("p");
            erro.style.color = 'rgb(167, 6, 6)';
            erro.textContent = "É necessário digitar a senha";
            erroLogin.appendChild(erro);
            form.appendChild(erroLogin);
        }
        if (nome.trim() === "") {
            const erroLogin = document.createElement("div");
            erroLogin.classList.add("mensagem-erro");
            let erro = document.createElement("p");
            erro.style.color = 'rgb(167, 6, 6)';
            erro.textContent = "É necessário digitar o nome";
            erroLogin.appendChild(erro);
            form.appendChild(erroLogin);
        }
        if (cpf.trim() === "") {
            const erroLogin = document.createElement("div");
            erroLogin.classList.add("mensagem-erro");
            let erro = document.createElement("p");
            erro.style.color = 'rgb(167, 6, 6)';
            erro.textContent = "É necessário digitar o cpf";
            erroLogin.appendChild(erro);
            form.appendChild(erroLogin);
        }
        if (email.trim() === "") {
            const erroLogin = document.createElement("div");
            erroLogin.classList.add("mensagem-erro");
            let erro = document.createElement("p");
            erro.style.color = 'rgb(167, 6, 6)';
            erro.textContent = "É necessário digitar o email";
            erroLogin.appendChild(erro);
            form.appendChild(erroLogin);
        }
        if (data.trim() === "") {
            const erroLogin = document.createElement("div");
            erroLogin.classList.add("mensagem-erro");
            let erro = document.createElement("p");
            erro.style.color = 'rgb(167, 6, 6)';
            erro.textContent = "É necessário digitar a data de nascimento";
            erroLogin.appendChild(erro);
            form.appendChild(erroLogin);
        }
    }
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