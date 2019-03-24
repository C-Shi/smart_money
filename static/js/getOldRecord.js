$(document).ready(function(){
  var date = new Date();
  var currentMonth = date.getMonth();
  var displayMonthName = GetMonthName(currentMonth - 1);
  $('#previousMonth').text(displayMonthName);


  function GetMonthName(monthNumber) {
    monthNumber = monthNumber < 0 ? monthNumber + 12 : monthNumber;
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    return months[monthNumber];
  }

  $('.month a').on('click', function(e) {
    // monthDiff if how many month we want to query from now
    var monthDiff = Number($(this).attr('id'));
    var userId = Number($('#user').attr('data-user-id'));
    displayMonthName = GetMonthName(currentMonth - monthDiff);
    $('#previousMonth').text(displayMonthName);

    // verify if we should ask for last year data
    var shouldQueryLastYear = currentMonth - monthDiff < 0
    queryPassInfo(monthDiff, userId, shouldQueryLastYear);
  })
  

  // ajax request for rendering previous month info
  function queryPassInfo(minus, userId, lastYear) {
    $.get({
      url: '/libs/previous_month.php',
      data: {
        minus: minus, 
        userId: userId,
        lastYear: lastYear
      }
    }).done(data => {
      var response = $.parseJSON(data);
      // clear out all record
      $('.previous-transaction-row').remove();

      // loopover 
      response.forEach(function(transaction){
        generateRecord(transaction);
      })
      
    
    })
  }

  // generate one line of transaction record
  function generateRecord(transaction){
    var template = $('#month-hidden').clone();
    template = template.removeAttr('id').attr('class', 'previous-transaction-row');
    template.children('td:nth-of-type(1)').text(transaction.date.split(' ')[0]);
    template.children('td:nth-of-type(2)').text(transaction.name);
    template.children('td:nth-of-type(3)').text(transaction.amount);
    template.find('input:nth-of-type(1)').attr('value', transaction.id);
    $('.previous-transaction').append(template);
  }
})