    
    var loader;
    function displayContent() {
       loader.style.display = 'none';
       document.getElementById('main-content').style.display = 'block';
    }
    function loadNow() {     
      window.setTimeout(displayContent, 1000); 
    }
    document.addEventListener("DOMContentLoaded", function() {
       loader = document.getElementById('loader');
       loadNow();
    });