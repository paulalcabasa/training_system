/*
 * ----------------- H E A D E R ---------------------
 *
 * 	Author: John Paul M. Alcabasa
 * 	Date Created: December 4, 2015
 * 	System: Vehicle Monitoring
 * 	Description: Utilities Class for common validation usage
 *
 * ---------------------------------------------------
 */


var utils = {
	
	 /*
	  *
	  * Validates text input
	  * @params element = element to be validated
	  * @params msg = message to show in validation
	  * 
	  * -> format of element to be validated:
	  * <div class="form-group">
	  *		<label class="control-label col-md-2"><abbr title="Travel Authorization Number">TA No.</abbr></label>
	  *     <div class="col-md-10">
	  *      	<input type="text" class="form-control" placeholder="Please enter the travel authorization number..." id="txt_ta_no"/>	                </div>
	  * 	</div>
	  *	</div>
	  8
	  * @returns ctr = a counter for counting errors, 1 = with error, 0 = valid
	  */
	validateTextInput: function(element,msg){
		var ctr = 0;
		if($.trim(element.val()) == ""){
			element.parent().children(".help-block").remove();
			element.parent().parent().addClass("has-error");
			element.parent().append("<span class='help-block text-danger'><i class='fa fa-warning' style='color:#f1c40f;'></i> "+msg+".</span>");
			ctr = 1;
		}
		else {
			element.parent().children(".help-block").remove();
			element.parent().parent().removeClass("has-error");
			ctr = 0;
		}
		return ctr;
	},

	/*
	 *
	 * Calls validateTextInput method when "input" method is triggered on "text boxes"
	 * @params element - refer to validateTextInput
	 * @params msg - refer to validateTextInput
	 *
	 */
	validateChangeInput: function(element,msg){
		element.on("input",function(){
			utils.validateTextInput(element,msg);
		});
	},

	/*
	 *
	 * Calls validateTextInput method when "changed" method is triggered on "select" elements or "comobo box"
	 * @params element - refer to validateTextInput
	 * @params msg - refer to validateTextInput
	 *
	 */
	validateChangeSelect: function(element,msg){
		element.on("change",function(){
			utils.validateTextInput(element,msg);
		});
	},

	/*
	 *
	 * Calls validateTextInput method when "dp.changed" method is triggered on "bootstrap datetimepicker instance" 
	 * bootstrap datetimepicker library link (source and documentation) = https://eonasdan.github.io/bootstrap-datetimepicker/
	 * @params element - refer to validateTextInput
	 * @params msg - refer to validateTextInput
	 *
	 */
	validateChangeDateTime: function(element,msg){
		element.on("dp.change",function(){
			utils.validateTextInput(element,msg);
		});
	},

	/*
     *
     * Sets title of modal element
     * @params modal_element = modal dom element
     * @params title = title to set on the modal
     * @params propert = propert to set on modal
     *
	 */
	setModalProperty: function(modal_element,value,property){
		if(property == ".modal-title") {
			modal_element.children().children().children().find(property).html(value);
		}
		else if(property == ".modal-body") {
			modal_element.children().children().find(property).html(value);
		}
	},

	/*
	 *  Set page headers
	 *	@params page_header_id = id of the page header
	 *  @params title = title of the page 
	 *  @params breadcrumb = breadcrumb for the page
 	 * 
	 */
	setPageHeader: function(page_header_id,title,breadcrumb){
	 	$("#" + page_header_id + " h1").html(title);
		$("#" + page_header_id + " .breadcrumb").html(breadcrumb);
	 },
	
	 /*
  	  * Method for marking error in input
  	  *
	  */
	markInputError: function(element,msg){
		element.parent().children(".help-block").remove();
		element.parent().parent().addClass("has-error");
		element.parent().append("<span class='help-block text-danger'><i class='fa fa-warning' style='color:#f1c40f;'></i> "+msg+".</span>");
	},

	/*
     *
	 */
	removeInputError: function(element){
		element.parent().children(".help-block").remove();
		element.parent().parent().removeClass("has-error");
	},

	/*
	 *
	 * Modal Closing
	 *
	 */
	 trackModalClose: function(modal_element,flag,loc){
	 	modal_element.on("hidden.bs.modal",function(){
			if(flag){
				loc.reload();
			}
		});
	 },

	previewImage:function(id,target) {
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById(id).files[0]);
		oFReader.onload = function (oFREvent) {
			document.getElementById(target).src = oFREvent.target.result;
		};
	}





}



