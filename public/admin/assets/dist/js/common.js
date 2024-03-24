// Preview Image
var filePreview = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('preview');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

var imagePreview = function(event, elm) {
  var reader = new FileReader();
  reader.onload = function(){
    var output = document.getElementById(elm);
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
};