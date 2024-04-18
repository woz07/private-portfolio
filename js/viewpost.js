function redirect(id) {
    sessionStorage.setItem('id', id);
    window.location.href = "comment.php";
}