 $(document).ready(function() {

   Handlebars.registerHelper('if_eq', function(a, b, opts) {
     if (a == b) {
       return opts.fn(this);
     } else {
       return opts.inverse(this);
     }
   });
   Handlebars.registerHelper('grouped_each', function(every, context, options) {
     var out = "",
       subcontext = [],
       i;
     if (context && context.length > 0) {
       for (i = 0; i < context.length; i++) {
         if (i > 0 && i % every === 0) {
           out += options.fn(subcontext);
           subcontext = [];
         }
         subcontext.push(context[i]);
       }
       out += options.fn(subcontext);
     }
     return out;
   });

   let selected = localStorage.getItem("selected")
   $('title').html(selected + "| myExperience");

   let output = {
     tableContent: [],
     headers: []
   };

   let itemSource = $("#itemTemplate").html();
   let itemTemplate = Handlebars.compile(itemSource);

   let addItemSource = $("#addItemTemplate").html();
   let addItemTemplate = Handlebars.compile(addItemSource);

   $.getJSON("php/loadTableHeaders.php?category=" + selected, function(data) {



     for (let i = 0; i < data.length; i++) {
       output.headers.push({
         headername: data[i].headername
       });
     }

     output.headers.push({
       headername: "edit"
     });
     output.headers.push({
       headername: "delete"
     });

   });


   $.getJSON("php/loadTableContent.php?category=" + selected, function(data) {

     //check if array is empty
     if (!Array.isArray(data) || !data.length) {
       $("#tableContainer").append(itemTemplate(output));

       output.headers.splice($.inArray("edit", output.headers), 1);
       output.headers.splice($.inArray("edited", output.headers), 1);
       output.headers.splice($.inArray("delete", output.headers), 1);

       $("#addItemContainer").append(addItemTemplate(output));
     } else {
       let firstItemId = data[0].itemid;

       Array.prototype.groupBy = function(prop) {
         return this.reduce(function(groups, item) {
           var val = item[prop];
           groups[val] = groups[val] || [];
           groups[val].push(item);
           return groups;
         }, {});
       }

       var byItemID = data.groupBy('itemid');
       output.tableContent.push(
         byItemID
       );

       $("#tableContainer").append(itemTemplate(output));

       output.headers.splice($.inArray("edit", output.headers), 1);
       output.headers.splice($.inArray("edited", output.headers), 1);
       output.headers.splice($.inArray("delete", output.headers), 1);


       $("#addItemContainer").append(addItemTemplate(output));
     }

   });
 });
