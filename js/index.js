$('input').focus(function(){
  var curr = $(this);
  if(curr.attr('placeholder')&& curr.val()!=""){
    $('.ph').fadeOut();
    curr.after('<div class="ph">'+curr.attr('placeholder')+'</div>');
    currparent().find('.ph').fadeIn();
  }
  //Remove 'error' class if input field has it
  if(curr.hasClass('error')) {
    curr.removeClass('error');
  }
});
$('input').keyup(function(){
  console.log($(this).val());
  if($(this).attr('placeholder')&&$(this).val!=""){
    $(this).after('<div class="ph">'+$(this).attr('placeholder')+'</div>');
    $(this).parent().find('.ph').fadeIn();
  }
});
$('input').blur(function(){
     $('.ph').fadeOut();
});


//Form Validation on Submit
$('form').submit(function(e) {
  e.preventDefault();
  var inputs = $('input, textarea','.required-field'),
  filledIn = [],
      complete = false;
  
  inputs.each(function(index) {
    filledIn.push('false');
  });
  
  inputs.each(function(index) {
    var curr = $(this),
        ph = curr.attr('placeholder');
    
    if(curr.hasClass('email')) {
      if(IsEmail(curr.val())) {
        filledIn[index] = true;
      } else {
        filledIn[index] = false;
        curr.addClass('error');
      }
      return;
    }
    
    if(curr.val() != ph && curr.val() != '') {
      filledIn[index] = true;
      curr.removeClass('error');
    } else {
      filledIn[index] = false;
      curr.addClass('error');
    }
  });
  
  for(var i=0;i<filledIn.length;i++) {
    var curr = filledIn[i];
    if(!curr) {
      complete = false;
      break;
    } else {
      complete = true;
    }
  };
  
  if(complete) {
    alert('Good on ya, maaate!');
  } else {
    alert('Try again, would ya?!'); 
  }
      
});

$('input[type=tel]', '.required-field').keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 107, 109, 189, 43]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
  
  if(((e.shiftKey && e.keyCode == 187) || e.keyCode == 107)) {
    return;
  }
  
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
