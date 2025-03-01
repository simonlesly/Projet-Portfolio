const cadreImage = document.getElementById("cadreImage");
const televerserImage = document.getElementById("televerserImage");
const preview = document.getElementById("preview");
const placeholder = document.getElementById("placeholder");

cadreImage.addEventListener("click", function() {
    televerserImage.click();  
        });
        
televerserImage.addEventListener("change", function(event) {
const file = event.target.files[0];

if (file) {
    const reader = new FileReader();
                
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = "block";
        placeholder.style.display = "none";  
        }
                
    reader.readAsDataURL(file);
        }
    });