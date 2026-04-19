document.addEventListener("DOMContentLoaded", function () {
    const tipus = document.getElementById("tipus");
    const kategoria = document.getElementById("kategoria");

    const kiadas = [
        "Élelmiszer",
        "Háztartás",
        "Elektronika",
        "Lakhatás",
        "Rezsi",
        "Hitel",
        "Biztosítás",
        "Ruházat",
        "Gyógyszer",
        "Egészségügy",
        "Edzés",
        "Autó",
        "Közlekedés",
        "Tanulmányok",
        "Utazás",
        "Szórakozás",
        "Ajándék",
        "Gyerek",
        "Állat",
        "Előfizetés",
        "Telefon",
        "Internet",
        "Egyéb"
    ];

    const bevetel = [
        "Fizetés",
        "Prémium",
        "Befektetés",
        "Részvény",
        "Visszatérítés",
        "Ajándék",
        "Másodállás",
        "Eladás",
        "Járandóság",
        "Ösztöndíj",
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
