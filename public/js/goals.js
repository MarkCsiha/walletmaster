const cont = document.getElementById("cont");
const centerPanel = document.getElementById("centerPanel");

window.onload = function(){
    change("goals")
}
function change(inf){
    if (inf === "goals") {
        cont.innerHTML = document.getElementById("goalsBody").innerHTML;
    } else if (inf === "add") {
        cont.innerHTML = document.getElementById("addBody").innerHTML;
    }

    centerPanel.classList.remove("d-none");
}
