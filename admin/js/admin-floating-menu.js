function enable_input(cl){

    var inputs = document.getElementsByClassName(cl)

    for (let index = 0; index < inputs.length; index++) {
        var element = inputs[index];
        
        element.disabled ? element.disabled = false : element.disabled = true
    }
    
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