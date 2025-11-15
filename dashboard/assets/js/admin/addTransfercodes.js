const createBillingCodeForm = document.querySelector("#createBillingCodeForm"),
createBillingCodeBtn = document.querySelector("#createBillingCodeBtn");

createBillingCodeForm.onsubmit = (e) =>{
    e.preventDefault(); // preventing form from submitting
}

createBillingCodeBtn.onclick = ()=>{
    // console.log("Working good");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../../backend/transaction/add_transfer_codes.php", true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                if(data == 'success'){
                    iziToast.show({
                        title: 'Hey',
                        message: `Code added successfully`,
                        position: "topRight",
                        backgroundColor: '#90EE90'
                    });
                }else{
                    iziToast.show({
                        title: 'Hey',
                        message: data,
                        position: "topRight",
                        backgroundColor: '#FF474C'
                    });
                }
            }
        }
    }
    //we have to send the form data through ajax to php
    let formData = new FormData(createBillingCodeForm); //creating new formdata object
    xhr.send(formData); //sending the form data to php
}