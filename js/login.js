const infoButton = document.getElementById('info');
const loginButton = document.getElementById('login');
const container = document.getElementById('container');

infoButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

loginButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});

window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);