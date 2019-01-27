var select = document.getElementById("new-transaction-option");
select.addEventListener('change', function(e){
  if(e.target.value === 'New'){
    var div = document.createElement('div');
    div.setAttribute('class', 'form-group');
    div.setAttribute('id', 'newCategoryDiv')
    var label = document.createElement('label');
    label.textContent = 'New Category';
    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('class', 'form-control');
    input.setAttribute('name', 'newCategory');
    input.setAttribute('placeholder', 'New Category');
    div.appendChild(label);
    div.appendChild(input);
    document.getElementById('new-form').appendChild(div);
  } else {
    var newCatDiv = document.getElementById('newCategoryDiv');
    document.getElementById('new-form').removeChild(newCatDiv);
  }
})

var toggleCategory = document.getElementById("toggle-category");
$('#toggle-category').on('click', function(){
  $('#display-category').slideToggle();
})