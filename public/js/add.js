const categories = {
  kiadas: [
    ["elelmiszer", "Élelmiszer"],
    ["haztartas", "Háztartás"],
    ["elektronika", "Elektronika"],
    ["lakhatas", "Lakhatás"],
    ["hitel", "Hitel"],
    ["ruhazat", "Ruházat"],
    ["gyogyszer", "Gyógyszer"],
    ["edzes", "Edzés"],
    ["auto", "Autó"],
    ["tanulmanyok", "Tanulmányok"],
    ["utazas", "Utazás"],
    ["szorakozas", "Szórakozás"],
    ["egyeb", "Egyéb"],
  ],
  bevetel: [
    ["fizetes", "Fizetés"],
    ["befektetes", "Befektetés"],
    ["reszveny", "Részvény"],
    ["jarandossag", "Járandóság"],
    ["egyeb", "Egyéb"],
  ],
};

function fillCategories(type, selectedValue = null) {
  const kategoria = document.getElementById("kategoria");
  kategoria.innerHTML = "";

  if (!categories[type]) {
    const opt = document.createElement("option");
    opt.value = "0";
    opt.textContent = "Válasszon típust először";
    kategoria.appendChild(opt);
    return;
  }

  for (const [val, text] of categories[type]) {
    const opt = document.createElement("option");
    opt.value = val;
    opt.textContent = text;
    if (selectedValue && selectedValue === val) opt.selected = true;
    kategoria.appendChild(opt);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const tipus = document.getElementById("tipus");
  const oldTipus = tipus.dataset.old;
  const kategoria = document.getElementById("kategoria");
  const oldKat = kategoria.dataset.old;

  // első betöltés (pl. validáció után old() miatt)
  fillCategories(oldTipus, oldKat);

  // változáskor újratölt
  tipus.addEventListener("change", (e) => {
    fillCategories(e.target.value, null);
  });
});
