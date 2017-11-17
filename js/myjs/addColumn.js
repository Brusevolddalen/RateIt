$(document).ready(function() {

  let output = {
    columnNumber: []
  };
  //let headers=[];
  let addColumnSource = $("#addColumnTemplate").html();
  let addColumnTemplate = Handlebars.compile(addColumnSource);

  $("#newColumnsButton").click(function() {

    for (let i = 1; i <= $("#numberOfColumns").val(); i++) {
      output.columnNumber.push(i);

    }
    $("#addColumnContainer").append(addColumnTemplate(output));
    $('select').material_select();
    output.columnNumber=[];

  });

});
