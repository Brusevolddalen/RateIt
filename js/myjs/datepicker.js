
$(document).ready(function() {

  $('select').material_select();

  var d = new Date();
  d.setFullYear( d.getFullYear() - 120 );
  var pickr = $('.datepicker').pickadate(
  {
     format: 'yyyy-mm-dd',
     selectMonths: true,
     selectYears: 120,
     min: d,
     max: new Date(),

  });

  /*
  $('#birthdateText').click(function() {
    console.log("asd");
    pickr.pickadate('open');
  });
  */



});
