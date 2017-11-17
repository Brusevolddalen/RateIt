$(document).ready(function() {

  $('select').material_select();

  $("#registerForm").submit(function(e) {
    e.preventDefault();
  });

});
