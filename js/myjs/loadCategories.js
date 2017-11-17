$(document).ready(function() {

  $.getJSON("php/loadCategories.php", function(data) {

    let source = $("#categoryTemplate").html();
    let template = Handlebars.compile(source);
    var output = {
      categories: []
    };

    //Adds the categorynames to output array and capitalizes the first letter in the array
    for (let i = 0; i < data.length; i++) {
      output.categories.push({
        categoryName: data[i].categoryname
      });
    }

    //Fills Array with the result from PHP
    $("#tableContainer").append(template(output));
  });
});
