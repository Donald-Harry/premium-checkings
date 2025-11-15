const addBalanceForm = document.querySelector("#add_balance_form"),
addBalanceBtn = document.querySelector("#add_balance_btn");

addBalanceForm.onsubmit = (e) =>{
    e.preventDefault(); // preventing form from submitting
}

addBalanceBtn.onclick = ()=>{
    // console.log("Working good");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../../backend/transaction/add_funds.php", true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                if(data == 'success'){
                    iziToast.show({
                        title: 'Hey',
                        message: `Balance added successfully`,
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
    let formData = new FormData(addBalanceForm); //creating new formdata object
    xhr.send(formData); //sending the form data to php
}