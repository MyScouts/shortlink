
(function ($) {
    $(document).ready(function () {
        const multiForm = document.querySelector("form.mutil-url"),
    paragraph = multiForm.querySelector("textarea"),
    mutilBtn = multiForm.querySelector("button"),
    multilPopup = $(".multil-popup-box"),
    multiCopy = $(".multil-popup-box .copy-icon");
    resultParagraph = $(".multil-popup-box textarea");

multiForm.onsubmit = (e)=>{
    e.preventDefault();
}

mutilBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "app/php/mutil-url-controll.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            let data = xhr.response;
            resultParagraph.text = data;
            multilPopup.addClass("show");
            resultParagraph.val(data);
        }
    }
    let mutltiFormData = new FormData(multiForm);
    xhr.send(mutltiFormData);
};

multiCopy.click(()=>{
    resultParagraph.select();
    document.execCommand('copy');
    multilPopup.removeClass("show");
})

multilPopup.click(function (e) {
    e.stopPropagation();
})

$(document).click(function () {
    multilPopup.removeClass("show");
})

    })
})(jQuery)

