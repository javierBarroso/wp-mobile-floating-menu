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

jQuery(document).ready(function() {
    var $ = jQuery;
    if ($('.set_custom_images').length > 0) {
        if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            $('.set_custom_images').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                var id = button.prev();
                wp.media.editor.send.attachment = function(props, attachment) {
                    id.val(attachment.id);
                };
                wp.media.editor.open(button);
                return false;
            });
        }
    }
});

function showResult (str) {
    if (str.length==0) { 
      document.getElementById("livesearch").innerHTML="";
      document.getElementById("livesearch").style.border="0px";
      return;
    }
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("livesearch").innerHTML=this.responseText;
        document.getElementById("livesearch").style.border="1px solid #A5ACB2";
      }
    }
    xmlhttp.open("GET","livesearch.php?q="+str,true);
    console.log(xmlhttp);
    xmlhttp.send();
  }

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

