const dragZone = document.getElementById("dragZone");
const fileInput = document.getElementById("importFile");
const droppingLogo = document.getElementById("droppingLogo");
const filePreview = document.getElementById("filePreview");
const filePreviewname = document.getElementById("fileName");
const removeFileBtn = document.getElementById("removeFileBtn");
const actionGroup = document.getElementById("actionGroup");

const allowedExtensions = /(\.csv|\.xls|\.xlsx)$/i;
let previousFile;

const toggleDragFile = () => {
    if(fileInput.value){
        dragZone.classList.remove("d-flex");
        dragZone.classList.add("d-none");

        filePreviewname.textContent = fileInput.files[0].name;
        filePreview.classList.remove("d-none");
        filePreview.classList.add("d-flex");

        actionGroup.classList.remove("d-none");
        actionGroup.classList.add("d-flex");
    }else{
        dragZone.classList.add("d-flex");
        dragZone.classList.remove("d-none");

        filePreviewname.textContent = "No File Selected";
        filePreview.classList.add("d-none");
        filePreview.classList.remove("d-flex");

        actionGroup.classList.add("d-none");
        actionGroup.classList.remove("d-flex");
    }
}

fileInput.addEventListener("change", (e) => {
    toggleDragFile();
});

dragZone.addEventListener("dragover", (e) => {
    e.preventDefault();

    droppingLogo.classList.add("fa-cloud-arrow-down");
    droppingLogo.classList.remove("fa-cloud-arrow-up");
});

dragZone.addEventListener("dragleave", (e) => {
e.preventDefault();

droppingLogo.classList.add("fa-cloud-arrow-up");
droppingLogo.classList.remove("fa-cloud-arrow-down");
});

dragZone.addEventListener('drop', (e) => {
    e.preventDefault();

    let files = e.dataTransfer.files;
    let dataTransfer = new DataTransfer();

    if(!allowedExtensions.exec(files[0].name)) {
        Swal.fire({
        title: 'Error!',
        text: 'Invalid file type. Only Excel files are allowed.',
        icon: 'warning',
        confirmButtonColor: 'var(--bs-danger)',
        confirmButtonText: 'OK'
        });
        if(fileInput.value){
            dataTransfer.items.add(previousFile);
            fileInput.files = dataTransfer.files;
        }else{
            fileInput.value = "";
        }
    }else{
        dataTransfer.items.add(files[0]);
        let filesToBeAdded = dataTransfer.files;
        fileInput.files = filesToBeAdded;
        toggleDragFile();
    }
});

removeFileBtn.addEventListener("click", (e) => {
    fileInput.value = "";
    toggleDragFile();
});