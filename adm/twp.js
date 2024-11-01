jQuery(document).ready(function($){
    $('.my-color-field').wpColorPicker({
        change: function (event, ui) {
            var element = event.target;
            var color = ui.color.toString();
            if(element.id == "twpformbg"){
                var div = document.getElementById('twpLoginFormDemo');
                div.style.background = color;
            }
            if(element.id == "twpformbgtextcolor"){
                var div = document.getElementById('twpnava');
                var div2 = document.getElementById('backtobloga');
                div.style.color = color;
                div2.style.color = color;
            }
            if(element.id == "twpformformbg"){
                var div = document.getElementById('loginform');
                div.style.background = color;
            }
            if(element.id == "twpformformtext"){
                var div = document.getElementById('twploginlabels');
                var div2 = document.getElementById('twploginlabels2'); 
                var div3 = document.getElementById('rememberme'); 
                div.style.color = color;
                div2.style.color = color;
                div3.style.color = color;
            }
            if(element.id == "twpformbtncolor"){
                var div = document.getElementById('wp-submit');
                div.style.background = color;
            }
            if(element.id == "twpformbtntxtcolor"){
                var div = document.getElementById('wp-submit');
                div.style.color = color;
            }     
        }
    });
});


