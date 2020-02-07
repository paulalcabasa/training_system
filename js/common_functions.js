function populate_year(){
  var today = new Date();
  var year  = today.getFullYear() + 1;
  for(i = 1; i <= 10; i++){
    $("#start_yr,#end_yr").append("<option value="+year+">" + year + "</option>");
    year--;
  }
}

function PreviewImage(id,target) {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById(id).files[0]);
    oFReader.onload = function (oFREvent) {
        document.getElementById(target).src = oFREvent.target.result;
    };
};

function remove_key_event(id){
	$(id).on("keydown", function (event) {
		event.preventDefault();
	});
}	

function computeDPYear(source,target,label){
	 $(source).on("dp.change",function(e){
		arr = $(this).data('date').split("-");
		year = arr[0];	
		var today = new Date();
		$(target).val((today.getFullYear() - year) + " " + label);
	});
}

function initializeDpYear(source,target,label){
  arr = $(source).val().split("-");
  year = arr[0];  
  var today = new Date();
  $(target).val((today.getFullYear() - year) + " " + label);
}

// function to mark errors in text box
function mark_error_input_vertical(id){
  $(id).parent().addClass("has-error");
  $(id).parent().addClass("has-feedback");
  $(id).next().removeClass("glyphicon-ok");
  $(id).next().addClass("glyphicon-remove");
  $(id).next().show("slow");
  $(id).next().next().show("slow");
  
}

// function to mark success in text box
function mark_success_input_vertical(id){
  $(id).parent().removeClass("has-error");
  $(id).parent().addClass("has-success");
  $(id).parent().addClass("has-feedback");
  $(id).next().show("slow");
  $(id).next().removeClass("glyphicon-remove");
  $(id).next().addClass("glyphicon-ok");
  $(id).next().next().hide("slow");
}

// function to validate input upon typing
function validate_input_vertical(id){
  $(id).on("input",function(){
    if($(this).val()!=""){
      mark_success_input_vertical(id);
    }
    else {
      mark_error_input_vertical(id);
    }
  });
}

// function to mark errors in text box
function mark_error_input(id){
  $(id).parent().parent().addClass("has-error");
  $(id).parent().parent().addClass("has-feedback");
  $(id).next().removeClass("glyphicon-ok");
  $(id).next().addClass("glyphicon-remove");
  $(id).next().show("slow");
  $(id).next().next().show("slow");
  
}

// function to mark success in text box
function mark_success_input(id){
  $(id).parent().parent().removeClass("has-error");
  $(id).parent().parent().addClass("has-success");
  $(id).parent().parent().addClass("has-feedback");
  $(id).next().show("slow");
  $(id).next().removeClass("glyphicon-remove");
  $(id).next().addClass("glyphicon-ok");
  $(id).next().next().hide("slow");
}

// function to validate input upon typing
function validate_input(id){
  $(id).on("input",function(){
    if($(this).val()!=""){
      mark_success_input(id);
    }
    else {
      mark_error_input(id);
    }
  });
}

// function to validate dates
function validate_date(id){
  if($(id).data('date') == undefined){
    $(id).parent().parent().addClass("has-error");
    $(id).next().show("slow");
    return true;
  } else {
    $(id).parent().parent().removeClass("has-error");
    $(id).parent().parent().addClass("has-success");
    $(id).next().hide("slow");
    return false;
  }
}

// function to check a valid email address
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function transformName(first_name,middle_name,last_name,name_extension){
  var name = "";
  name = "<span style='text-transform:capitalize;font-weight:bold;'>" + $(last_name).val() + "</span> ";
  name += ($(first_name).val()!="") ? "<span style='text-transform:capitalize;font-weight:bold;'>" + $(first_name).val() + "</span> " : "";
  name += ($(middle_name).val()!="") ? "<span style='text-transform:capitalize;font-weight:bold;'>" + $(middle_name).val() + "</span>" : "";
  name += (name_extension!="") ? ", <span style='text-transform:capitalize;font-weight:bold;'>" + name_extension + "</span>": "";
  return name;
}

function insertCommas(s) {

    // get stuff before the dot
    var d = s.indexOf('.');
    var s2 = d === -1 ? s : s.slice(0, d);

    // insert commas every 3 digits from the right
    for (var i = s2.length - 3; i > 0; i -= 3)
      s2 = s2.slice(0, i) + ',' + s2.slice(i);

    // append fractional part
    if (d !== -1)
      s2 += s.slice(d);

    return s2;
}