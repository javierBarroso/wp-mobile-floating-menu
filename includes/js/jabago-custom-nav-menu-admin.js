var iconSelectorButton = document.querySelectorAll('.icon-selector-button');



function showIconSelectorPanel(id){
    panel = document.getElementById('icon-panel');
    console.log('test');
    if(panel.className == 'icon-modal hide'){
        panel.className = 'icon-modal show'
    }else{
        panel.className = 'icon-modal hide'
    }
}

function enable_input(cl, enable){

    var inputs = document.getElementsByClassName(cl);

    for (let index = 0; index < inputs.length; index++) {

        var element = inputs[index];
        element.disabled = !enable.checked;

    }

}

function enable_custom_header_image_input(value){
    console.log(value)
    var custom_image_button = document.querySelector('#logo-select-container');

    (value == 'custom-image') ? custom_image_button.style.display = 'grid' : custom_image_button.style.display = 'none'
}

function select_logo(){
    upload = wp.media({title: 'Select headr\'s image', button: {text: 'Use this image'}}).on('select', function(){
        var attachment = upload.state().get('selection').first().toJSON()
        if(document.getElementById('logo-preview')){
            document.getElementById('logo-preview').remove();
        }
        document.getElementById('logo-preview-container').innerHTML = '<img src="' + attachment.url + '" style="object-fit:contain" width=100 height=100 name="logo-preview" id="logo-preview" style="object-fit: cover;">'
        document.getElementById('logo').value = attachment.url
    }).open()
}

function openTab(event, id){

    var tabContents = document.getElementsByClassName('tab-content');

    var tabLinks = document.getElementsByClassName('tab');

    for (let index = 0; index < tabLinks.length; index++) {
        var element = tabLinks[index];
        element.className = element.className.replace(" active", "");
    }
    
    for (let index = 0; index < tabContents.length; index++) {
        var element = tabContents[index];
        element.style.display = 'none';
    }

    document.getElementById(id).style.display = 'grid';
    event.currentTarget.className += " active";
    
}



function slider(){
    var slider = document.getElementsByClassName("range-picker");

    for (let index = 0; index < slider.length; index++) {
        const value = slider[index].value;
        
        slider[index].nextElementSibling.innerHTML = Number(value).toFixed(1) + ' em';
    }
    
};

/* preview */


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