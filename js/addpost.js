document.addEventListener('DOMContentLoaded', function() {
    const element = document.getElementById("clear");
    const title = document.getElementById("title");
    const body = document.getElementById("body");

    title.classList.remove("error");
    body.classList.remove("error");

    // clear
    element.addEventListener('click', () => {
            title.value = "";
            body.value = "";
    });

    title.addEventListener("keyup", () => {
        if (title.value.length > 0) {
            title.classList.remove("error");
        }
    });
    
    body.addEventListener("keyup", () => {
        if (body.value.length > 0) {
            body.classList.remove("error");
        }
    });    

    const submit = document.getElementById("submit");
    submit.addEventListener("click", () => {
        if (title.value === "" || body.value === "") {
            event.preventDefault();
            title.classList.add("error");
            body.classList.add("error");
            alert("Please fill in the title and content for the post.")
        }
    });
});