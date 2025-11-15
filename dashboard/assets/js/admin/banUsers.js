const ban_user = document.querySelector('#ban_user'),
ban_user_form = document.querySelector('#ban_user_form');

ban_user.onclick = ()=>{
    Swal.fire({
        title: "Are you sure you want to ban this user?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Ban",
        denyButtonText: `Don't ban`
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../../../backend/account/ban_user.php", true);
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);
                        if(data == 'success'){
                            Swal.fire("Saved!", "", "success");
                        }else{
                            Swal.fire("Error!", "", "error");
                        }
                    }
                }
            }
            //we have to send the form data through ajax to php
            let formData = new FormData(ban_user_form); //creating new formdata object
            xhr.send(formData); //sending the form data to php
        } else if (result.isDenied) {
            Swal.fire("Changes are not saved", "", "info");
        }
    });
}