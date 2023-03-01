function deleteSubmit(id = null) {
    if(confirm('Estas seguro?')) {
        if(!id) document.getElementById("deleteForm").submit();
        else {
            document.getElementById(id).submit();
        }
    }
}