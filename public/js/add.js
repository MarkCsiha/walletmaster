
const categories = {
  kiadas: [
    ["Élelmiszer", "Élelmiszer"],
    ["Háztartas", "Háztartás"],
    ["Elektronika", "Elektronika"],
    ["Lakhatás", "Lakhatás"],
    ["Hitel", "Hitel"],
    ["Ruházat", "Ruházat"],
    ["Gyógyszer", "Gyógyszer"],
    ["Edzés", "Edzés"],
    ["Autó", "Autó"],
    ["Tanulmányok", "Tanulmányok"],
    ["Utazás", "Utazás"],
    ["Szórakozás", "Szórakozás"],
    ["Egyéb", "Egyéb"],
  ],
  bevetel: [
    ["Fizetés", "Fizetés"],
    ["Befektetés", "Befektetés"],
    ["Részvény", "Részvény"],
    ["Járandóság", "Járandóság"],
    ["Egyéb", "Egyéb"],
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
  const suggestedKat = kategoria.dataset.suggested;

  // ha van old kategoria, az nyer, különben a suggested
  const initialKat = (oldKat && oldKat !== "0") ? oldKat : (suggestedKat || null);

  fillCategories(oldTipus, initialKat);

  tipus.addEventListener("change", (e) => {
    fillCategories(e.target.value, null);
  });
});

