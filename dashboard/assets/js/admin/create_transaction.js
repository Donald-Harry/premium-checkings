const createTransactionHistoryForm = document.querySelector("#createTransactionHistoryForm"),
createTransactionHistoryBtn = document.querySelector("#createTransactionHistoryBtn");

createTransactionHistoryForm.onsubmit = (e) =>{
    e.preventDefault(); // preventing form from submitting
}

createTransactionHistoryBtn.onclick = ()=>{
    // console.log("Working good");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../../backend/transaction/create_transaction_history.php", true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                if(data == 'success'){
                    iziToast.show({
                        title: 'Hey',
                        message: `Code updated successfully`,
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
    let formData = new FormData(createTransactionHistoryForm); //creating new formdata object
    xhr.send(formData); //sending the form data to php
}