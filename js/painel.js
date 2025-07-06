// Event listener para botões de painel.php



document.getElementById('buscarbtn').addEventListener("click", () => {
    window.location.href = "../php/busca.php";
});

document.getElementById('adicionarbtn').addEventListener("click", () => {
    window.location.href = '../php/adicionar.php'
})

document.getElementById('editarbtn').addEventListener('click', () => {
    window.location.href = '../php/editar.php';
})

document.getElementById('removerbtn').addEventListener('click', () => {
    window.location.href = '../php/remover.php';
})

document.getElementById('sairbtn').addEventListener('click', () => {
    window.location.href = '../php/logout.php';
})

