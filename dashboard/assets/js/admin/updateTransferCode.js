const updateTransferCodesForm = document.querySelector("#updateTransferCodesForm"),
updateTransferCodesBtn = document.querySelector("#updateTransferCodesBtn"),
deleteTransferCodes = document.querySelector("#deleteTransferCodes");

updateTransferCodesForm.onsubmit = (e) =>{
    e.preventDefault(); // preventing form from submitting
}

updateTransferCodesBtn.onclick = ()=>{
    // console.log("Working good");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../../backend/transaction/update_transfer_code.php", true);
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
    let formData = new FormData(updateTransferCodesForm); //creating new formdata object
    xhr.send(formData); //sending the form data to php
}

deleteTransferCodes.onclick = ()=>{
    Swal.fire({
        title: "Are you sure you want to delete this codes?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Delete",
        denyButtonText: `Don't delete`
    }).then((result) => {
        if (result.isConfirmed) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../../../backend/transaction/delete_transaction_code.php", true);
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);
                        if(data == 'success'){
                            Swal.fire("Done!", "", "success");
                        }else{
                            Swal.fire("Error!", "", "error");
                        }
                    }
                }
            }
            //we have to send the form data through ajax to php
            let formData = new FormData(updateTransferCodesForm); //creating new formdata object
            xhr.send(formData); //sending the form data to php
        } else if (result.isDenied) {
            Swal.fire("Changes are not saved", "", "info");
        }
    });
}