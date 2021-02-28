let infos = document.getElementById('infos');
let info = document.getElementById('info');
let commande = document.getElementById('commande');
let adresses = document.getElementById('adresses');
let adresse = document.getElementById('adresse');
let commandes = document.getElementById('commandes');


info.addEventListener('click', function(){
    infos.classList = 'd-block';
    adresses.classList = 'd-none';
    commandes.classList = 'd-none';
});
adresse.addEventListener('click', function(){
    adresses.classList = 'd-block';
    infos.classList = 'd-none';
    commandes.classList = 'd-none';
});
commande.addEventListener('click', function(){
    commandes.classList = 'd-block';
    infos.classList = 'd-none';
    adresses.classList = 'd-none';
});
