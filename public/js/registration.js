let password = document.getElementById("password");
let leng = document.getElementById("length");
let alph = document.getElementById("alph");
let num = document.getElementById("num");
let lucase = document.getElementById("lucase");
let spec = document.getElementById("spec");

leng.style.color = "tomato";
alph.style.color = "tomato";
num.style.color = "tomato";
lucase.style.color = "tomato";
spec.style.color = "tomato";

function check(){
    if(password.value.length >= 8){
        leng.style.color = "#00FA9A";
    } else {
        leng.style.color = "tomato";
    }

    if(/[a-zA-Z]/.test(password.value)){
        alph.style.color = "#00FA9A";
    } else {
        alph.style.color = "tomato";
    }

    if(/[0-9]/.test(password.value)){
        num.style.color = "#00FA9A";
    } else {
        num.style.color = "tomato";
    }

    if(/[a-z]/.test(password.value) && /[A-Z]/.test(password.value)){
        lucase.style.color = "#00FA9A";
    } else {
        lucase.style.color = "tomato";
    }

    if(/[^A-Za-z0-9]/.test(password.value)){
        spec.style.color = "#00FA9A";
    } else {
        spec.style.color = "tomato";
    }
}
