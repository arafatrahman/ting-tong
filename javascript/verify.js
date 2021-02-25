const form = document.querySelector(".verify form"),
verifyBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

verifyBtn.onclick = ()=>{


    

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/verify.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){              
            alert(xhr.responseText);
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}