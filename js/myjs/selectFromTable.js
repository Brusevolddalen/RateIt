$(document).on("click", "#table>tbody>tr", function() {

  let selected = $(this).text().replace(/ /g,'');
  localStorage.clear();
  localStorage.setItem("selected", selected);
  window.location.href = 'items.html?category='+selected;

});
