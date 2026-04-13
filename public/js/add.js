document.addEventListener("DOMContentLoaded", function () {
    const tipus = document.getElementById("tipus");
    const kategoria = document.getElementById("kategoria");

    const kiadas = [
        "Élelmiszer",
        "Háztartás",
        "Elektronika",
        "Lakhatás",
        "Hitel",
        "Ruházat",
        "Gyógyszer",
        "Edzés",
        "Autó",
        "Tanulmányok",
        "Utazás",
        "Szórakozás",
        "Egyéb"
    ];

    const bevetel = [
        "Fizetés",
        "Befektetés",
        "Részvény",
        "Járandóság",
        "Egyéb"
    ];

    function tipusValaszt(x) {
        kategoria.innerHTML = "";
        let lista = [];

        if (x == "kiadas") {
            lista = kiadas;
        }

        if (x == "bevetel") {
            lista = bevetel;
        }

        if (lista.length === 0) {
            kategoria.innerHTML = `<option value="">Válasszon típust először</option>`;
            return;
        }

        for (let i = 0; i < lista.length; i++) {
            kategoria.innerHTML += `<option value="${lista[i]}">${lista[i]}</option>`;
        }
    }

    tipus.addEventListener("change", function () {
        tipusValaszt(this.value);
    });
});
