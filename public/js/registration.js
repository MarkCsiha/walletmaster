let password = document.getElementById("password");
let leng = document.getElementById("length");
let alph = document.getElementById("alph");
let num = document.getElementById("num");
let lucase = document.getElementById("lucase");
let spec = document.getElementById("spec");

leng.style.color = "#FDEBE7";
alph.style.color = "#FDEBE7";
num.style.color = "#FDEBE7";
lucase.style.color = "#FDEBE7";
spec.style.color = "#FDEBE7";

function check(){
    if(password.value.length >= 8){
        leng.style.color = "lime";
    } else {
        leng.style.color = "#FDEBE7";
    }

    if(/[a-zA-Z]/.test(password.value)){
        alph.style.color = "lime";
    } else {
        alph.style.color = "#FDEBE7";
    }

    if(/[0-9]/.test(password.value)){
        num.style.color = "lime";
    } else {
        num.style.color = "#FDEBE7";
    }

    if(/[a-z]/.test(password.value) && /[A-Z]/.test(password.value)){
        lucase.style.color = "lime";
    } else {
        lucase.style.color = "#FDEBE7";
    }

    if(/[^A-Za-z0-9]/.test(password.value)){
        spec.style.color = "lime";
    } else {
        spec.style.color = "#FDEBE7";
    }
}
