const updateTransferHistoryForm = document.querySelector("#update_transfer_form"),
updateTransferHistoryBtns = document.querySelectorAll(".update_transfer_btn");
// deleteWithdrawHistoryBtns = document.querySelectorAll(".delete_withdraw_btn")

updateTransferHistoryForm.onsubmit = (e) =>{
    e.preventDefault(); // preventing form from submitting
}

updateTransferHistoryBtns.forEach(updateTransferHistoryBtn =>{
    updateTransferHistoryBtn.onclick = ()=>{
        console.log("Working good");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../../../backend/transfer/updateTransfer.php", true);
        xhr.onload = () =>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);
                    if(data == 'success'){
                        iziToast.show({
                            title: 'Hey',
                            message: `Transfer updated successfully`,
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
        let formData = new FormData(updateTransferHistoryForm); //creating new formdata object
        xhr.send(formData); //sending the form data to php
    }

})

// deleteTransactionHistoryBtns.forEach(deleteTransactionHistoryBtn => {
//     deleteTransactionHistoryBtn.onclick = ()=>{
//         console.log('deleteTransactionHistory');
//         Swal.fire({
//             title: "Are you sure you want to delete this transaction history?",
//             showDenyButton: true,
//             showCancelButton: true,
//             confirmButtonText: "Delete",
//             denyButtonText: `Don't delete`
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 let xhr = new XMLHttpRequest();
//                 xhr.open("POST", "../../../backend/transaction/delete_transaction_history.php", true);
//                 xhr.onload = () =>{
//                     if(xhr.readyState === XMLHttpRequest.DONE){
//                         if(xhr.status === 200){
//                             let data = xhr.response;
//                             console.log(data);
//                             if(data == 'success'){
//                                 Swal.fire("Done!", "", "success");
//                             }else{
//                                 Swal.fire("Error!", "", "error");
//                             }
//                         }
//                     }
//                 }
//                 //we have to send the form data through ajax to php
//                 let formData = new FormData(updateTransactionHistoryForm); //creating new formdata object
//                 xhr.send(formData); //sending the form data to php
//             } else if (result.isDenied) {
//                 Swal.fire("Changes are not saved", "", "info");
//             }
//         });
//     }
// })
