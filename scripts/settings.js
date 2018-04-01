var menu_displayed = false;
var hamburger = document.getElementById('hamburger');
var menu_container = document.getElementById('menu_container');
hamburger.onclick = function(e){
    e = e || event;
    if(menu_displayed){
        menu_container.style.display = 'none';
        menu_displayed = false;
        e.target.title = "Pokaż menu";
        hamburger.className = "hamburger";
    }
    else{
        menu_container.style.display = 'block';
        menu_displayed = true;
        e.target.title = "Schowaj menu";

        hamburger.className = "hamburger hamburger--open";
    }
}
