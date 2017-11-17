$(document).ready(function() {
  // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
  $('.category-modal').modal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .8, // Opacity of modal background
      inDuration: 300, // Transition in duration
      outDuration: 200, // Transition out duration
      startingTop: '4%', // Starting top style attribute
      endingTop: '10%', // Ending top style attribute
      height: "10%",
    }
  );
  $('select').material_select();

  


});
