$(document).ready(function() {


  $.getJSON("php/loadMasterCategories.php", function(data) {

    let source = $("#masterCategoryTemplate").html();
    let template = Handlebars.compile(source);
    var output = {
      masterCategories: []
    };

    //console.log(data);


    //Fills Array with the result from PHP
    for (let i = 0; i < data.length; i++) {
      output.masterCategories.push({
        categoryName: data[i].categoryname
      });

    }
/*
    //capitalize first letter
    for(let i=0; i<output.masterCategories.length; i++){
    output.masterCategories[i].categoryName = output.masterCategories[i].categoryName.charAt(0).toUpperCase() + output.masterCategories[i].categoryName.substr(1);
    }
    */
    //Adds the Master Categories in to the card
    $("#welcomeCard").append(template(output));

  });

});
