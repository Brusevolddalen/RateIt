$(document).ready(function() {

  //add item modal
  $('.item-modal').modal({
    dismissible: true, // Modal can be dismissed by clicking outside of the modal
    opacity: .8, // Opacity of modal background
    inDuration: 300, // Transition in duration
    outDuration: 200, // Transition out duration
    startingTop: '4%', // Starting top style attribute
    endingTop: '10%', // Ending top style attribute
    height: "10%",
  });
  $('select').material_select();

  let output = {
    item: []
  };

  let editItemSource = $("#editItemTemplate").html();
  let editItemTemplate = Handlebars.compile(editItemSource);

  $('body').on('click', function(event) {
    if (!$('#editRowModal').is(':visible')) {
      $("#editRowContainer").html(editItemTemplate(output));
    }
  });

  $(document).on('click', '.table-edit-btn', function(event) {



    let row = $(this).closest("tr"); // Finds the closest row <tr>
    let tds = row.find("td"); // Finds all children <td> elements
    let selectedId = $(tds[0]).text();
    let tempData;

    $.post("php/loadItem.php", {
        itemid: selectedId
      })
      .done(function(data) {

        tempData = JSON.parse(data)
        for (let i = 0; i < tempData.length; i++) {

          output.item.push({
            header: tempData[i].headername,
            value: tempData[i].tablevalue,
            itemid: tempData[i].itemid
          });
        }
        $("#editRowContainer").html(editItemTemplate(output));
        output.item = [];
      });
  });

  $(document).on('click', '.table-delete-btn', function(event) {

    let row = $(this).closest("tr"); // Finds the closest row <tr>
    let tds = row.find("td"); // Finds all children <td> elements
    let selectedId = $(tds[0]).text();

    $.post("php/deleteRow.php", {
      itemid: selectedId
    });
    location.reload();



  });

});
