const form = document.querySelector("form");
const continueBtn = form.querySelector("button.btn-register");
const errorText = form.querySelector(".error-text");
const errorBox = form.querySelector(".error-box");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = () =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../server/register.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                    location.href = "login.php?success=";
                } else {
                    errorBox.style.display = "flex";
                    errorText.textContent = data;
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}