var elem = document.getElementById('toast');
if (elem) {
    var toast = new bootstrap.Toast(elem, {
        delay: 2000
    })
    toast.show()
}
