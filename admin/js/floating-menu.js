const mobileMenu = document.querySelector(".floating-nav-menu");
const navToggle = document.querySelector(".mobile-nav-toggle");
const menuItem = document.querySelectorAll(".menu-item");
const menuBackground = document.querySelector(".floating-menu-back");

//mobileMenu.setAttribute('data-visible', false);

function drop_down(id) {

    var dropDown = document.getElementById('item-drop-selector-' + id).innerText = '+';

    //dropDown.innerHTML = '+';
    

    
    
}

const activePage = window.location.href

const navLinks = document.querySelectorAll('nav a').forEach(link => {
    if(link.href == activePage){
        
        link.classList.add('active')
    }
})




navToggle.addEventListener("click", () => {
    const visibility = mobileMenu.getAttribute('data-visible');
    
    if(visibility === 'false'){
        mobileMenu.setAttribute('data-visible', true)
        navToggle.setAttribute('aria-expanded', true)
        menuBackground.classList += ' active'
    }else{
        mobileMenu.setAttribute('data-visible', false)
        navToggle.setAttribute('aria-expanded', false)
        menuBackground.classList = 'floating-menu-back'
    }
});

var activeSubMenu = null;

function openSubmenu(id){
    var allSubMenu = document.querySelectorAll('.floating-nav-submenu');

    var subMenu = document.getElementById('floating-nav-submenu-' + id);

    var subMenuIcon = document.getElementById('expand-icon-' + id);
    
    
    //console.log(document.getElementById('menu-item-'+id));


    if(subMenu){
        
        var visibility = subMenu.getAttribute('data-visible');
        
        if(visibility === 'false'){

            subMenu.setAttribute('data-visible', true);
            subMenu.style.maxHeight =  subMenu.scrollHeight + 'px';
            if(subMenu.parentElement.parentElement.style.maxHeight){

                subMenu.parentElement.parentElement.style.maxHeight = Number(subMenu.parentElement.parentElement.style.maxHeight.substring(0, subMenu.parentElement.parentElement.style.maxHeight.length - 2)) + subMenu.scrollHeight + 'px';
            }
            //subMenu.style.height = subMenu.offsetHeight + 'px'
            activeSubMenu = subMenu;
            //subMenuIcon.innerText = '-';
            subMenuIcon.getElementsByTagName('svg')[0].style.transform = "rotateZ(90deg)";
            

            /* allSubMenu.forEach(element => {
                if(element != activeSubMenu){
                    element.setAttribute('data-visible', false);
                }
            }); */

        }else{

            subMenu.setAttribute('data-visible', false);
            subMenu.style.maxHeight = null
            activeSubMenu = null;
            //subMenuIcon.innerText = '+';
            subMenuIcon.getElementsByTagName('svg')[0].style.transform = "rotateZ(0deg)";
            
        }
        subMenu=null

    }
    
}

/* menuItem.forEach(item => {
    
    item.addEventListener("click", (e) => {

        var subMenu = document.getElementById('floating-nav-submenu-' + item.getAttribute('data'));

        var allSubMenu = document.querySelectorAll('.floating-nav-submenu');

        var subMenu = document.getElementById('floating-nav-submenu-' + item.getAttribute('data'));
        
        
        console.log(e);


        if(subMenu){
            
            var visibility = subMenu.getAttribute('data-visible');
            
            if(visibility === 'false' && activeSubMenu != subMenu){

                subMenu.setAttribute('data-visible', true);
                activeSubMenu = subMenu;

                 allSubMenu.forEach(element => {
                    if(element != activeSubMenu){
                        element.setAttribute('data-visible', false);
                    }
                }); 

            }else{

                subMenu.setAttribute('data-visible', false);
                activeSubMenu = null;
                
            }
            subMenu=null

        }
        
    });
}); */

