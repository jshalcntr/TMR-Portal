let alertTimeout

$("#loginForm").submit(async function (e) { 
    e.preventDefault();
    
    const formData = $(this).serialize();
    try{
        const loginStatus = await authenticationRequest(formData);

        if(loginStatus.status === "success"){
            const userData = loginStatus.data;
            if(userData.role === "ADMIN"){
                window.location.href = "views/admin/dashboard.php"
            }else if(userData.role === "USER" || userData.role === "HEAD"){
                window.location.href = "views/user/dashboard.php"
            }else if(userData.role === "S-ADMIN"){
                window.location.href = "views/s-admin/dashboard.php"
            }
        }else if(loginStatus.status === "failed"){
            $("#errorModal").empty();
            $('#errorModal').append(`
                <div class="alert alert-danger alert-dismissible text--white fade" role="alert" style="z-index: 1;" id="alert">
                    <strong>${loginStatus.message}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            if(alertTimeout){
                clearTimeout(alertTimeout);
            }
            setTimeout(() => {
                $("#alert").toggleClass('show');
            }, 100);

            alertTimeout = setTimeout(() => {
                $("#alert").removeClass('show');
                setTimeout(() => {
                    $("#alert").remove();
                }, 250);
            }, 3000);
        }
    }catch (error) {
        // console.error('Error:', error);
        $("#errorModal").empty();
            $('#errorModal').append(`
                <div class="alert alert-danger alert-dismissible text--white fade" role="alert" style="z-index: 1;" id="alert">
                    <strong>An internal error occurred. Please contact MIS.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            if(alertTimeout){
                clearTimeout(alertTimeout);
            }
            setTimeout(() => {
                $("#alert").toggleClass('show');
            }, 100);

            alertTimeout = setTimeout(() => {
                $("#alert").removeClass('show');
                setTimeout(() => {
                    $("#alert").remove();
                }, 250);
            }, 3000);
    }
});

const authenticationRequest = (data) => {
    return new Promise((resolve, reject)=>{
        $.ajax({
            type: "POST",
            url: "backend/authenticate.php",
            data: data,
            success: (response)=> {
                resolve(response);
            },
            error:(xhr, status,error)=>{
                reject([xhr, status, error]);
                console.error("AJAX Request Error: ", error);
                console.log("Status: ", status);
                console.log("XHR: ", xhr.responseText);
            }
        });
    })
}