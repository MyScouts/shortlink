

(function ($) {
    $(document).ready(function () {
        
// shorten single url
const form = document.querySelector("form.single-url"),
    fullURL = form.querySelector("input"),
    shortenBtn = form.querySelector("button"),
    blurEffect = document.querySelector(".blur-effect"),
    popupBox = document.querySelector(".popup-box"),
    infoBox = popupBox.querySelector(".info-box"),
    form2 = popupBox.querySelector("form.edit-url"),
    shortenURL = popupBox.querySelector("form.edit-url .shorten-url"),
    copyIcon = popupBox.querySelector("form.edit-url .copy-icon"),
    saveBtn = popupBox.querySelector("form.edit-url button"),

    singleCopy = $(".single-copy-icon");

form.onsubmit = (e)=>{
    e.preventDefault();
}

singleCopy.click(function () {
    $(this).prev().select();
    document.execCommand('copy');
})

shortenBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "app/php/url-controll.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            let data = xhr.response;
            if(data.length <= 5){
                blurEffect.style.display = "block";
                popupBox.classList.add("show");

                //paste your url here. Like this: codingnepalweb.com/
                let domain = "https://longhousee.com/";
                shortenURL.value = domain + data;
                copyIcon.onclick = ()=>{
                    shortenURL.select();
                    document.execCommand("copy");
                    alert("Copy");
                }

                saveBtn.onclick = ()=>{
                    form2.onsubmit = (e)=>{
                        e.preventDefault();
                    }

                    let xhr2 = new XMLHttpRequest();
                    xhr2.open("POST", "app/php/save-url.php", true);
                    xhr2.onload = ()=>{
                        if(xhr2.readyState == 4 && xhr2.status == 200){
                            let data = xhr2.response;
                            if(data == "success"){
                                location.reload();
                            }else{
                                infoBox.classList.add("error");
                                infoBox.innerText = data;
                            }
                        }
                    }
                    let shorten_url1 = shortenURL.value;
                    let hidden_url = data;
                    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr2.send("shorten_url="+shorten_url1+"&hidden_url="+hidden_url);
                }
            }else{
                alert(data);
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
};
    })
})(jQuery)
