<?php
require_once("initialize.php");
require_once("includes/header_files.php");
$evaluation = new Evaluation();
$competency_list = $evaluation->getCompetencyList();
$ratings_list = $evaluation->getRatingsList();
?>

<div id="container">
	<div class="page-wrapper">
		  
      <h1>Competency and Rating</h1>
      <hr/>
      <div class="row">

          <div class="col-md-6">
               <div class="panel panel-primary">
                <div class="panel-heading">Competency</div>
                <div class="panel-body"> 
                   <ul class="list-group" id="competency_list">
                    <?php
                        foreach($competency_list as $competency){
                            $competency = (object)$competency;
                    ?>
                        <li class="list-group-item" data-competency_id="<?php echo $competency->id?>">
                            <span class="description"><?php echo $competency->competency;?></span>
                            <span class="controls pull-right">
                                <a href="#" class="btn_edit_competency" title="Click to edit" style="margin-right:1em;" ><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn_deactivate_competency" title="Click to deactivate"><i class="glyphicon glyphicon-ban-circle"></i></a>  
                            </span>
                        </li>
                    <?php
                        }
                    ?>           
                   </ul>
                    
                    <div class="input-group">
                            <input class="form-control" placeholder="Add competency" id="txt_competency" type="text">
                                <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="btn_add_competency">Add</button>
                        </span>
                    </div>

                </div>
              
            </div>
          </div>  

        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Rating</div>
                <div class="panel-body"> 
                    <ul class="list-group" id="ratings_list">
                    <?php
                        foreach($ratings_list as $rating){
                            $rating = (object)$rating;
                    ?>
                        <li class="list-group-item" data-rating_id="<?php echo $rating->id?>">
                            <span class="description"><?php echo $rating->rating;?></span>
                            <span class="controls pull-right">
                                <a href="#" class="btn_edit_rating" title="Click to edit" style="margin-right:1em;" ><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn_deactivate_rating" title="Click to deactivate"><i class="glyphicon glyphicon-ban-circle"></i></a>  
                            </span>
                        </li>
                    <?php
                        }
                    ?>    
                    </ul>

                    <div class="input-group">
                            <input class="form-control" placeholder="Add rating" id="txt_rating" type="text">
                                <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="btn_add_rating">Add</button>
                        </span>
                    </div>


                </div>
                
              </div>
           </div>
       </div>
	</div> <!-- end of page content wrapper -->

</div> <!-- end of wrapper -->

<div class="modal fade" tabindex="-1" role="dialog" id="dialog_update_competency">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Competency</h4>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label class="control-label">Description</label>
                <input type="text" class="form-control" id="txt_update_competency" />
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_update_competency">Save changes</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="dialog_update_rating">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Rating</h4>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label class="control-label">Description</label>
                <input type="text" class="form-control" id="txt_update_rating" />
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_update_rating">Save changes</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php 

  include("includes/footer.php");
  include("includes/js_files.php");
?>

<script>

$(document).ready(function(){
    
    var competency_id = 0;
    var competency_description;

    var rating_id = 0;
    var rating_description;

    var sortableCompetency = Sortable.create($("#competency_list")[0], // dragging ended
        {
            onEnd: function (/**Event*/evt) {
                // update sequence in database
                var competency_list = [];
                var index = 0;
                $("#competency_list li").each(function(){
                    competency_list[index] = $(this).data("competency_id");
                    index++;
                });

               $.ajax({
                    type:"POST",
                    data:{
                        competency_list : competency_list
                    },
                    url:"ajax/update_competency_sequence.php",
                    success:function(response){

                    }
               });
            }
        }
    );

    var sortableRatings = Sortable.create($("#ratings_list")[0], // dragging ended
        {
            onEnd: function (/**Event*/evt) {
                // update sequence in database 
                var rating_list = [];
                var index = 0;
                $("#ratings_list li").each(function(){
                    rating_list[index] = $(this).data("rating_id");
                    index++;
                });
          
               $.ajax({
                    type:"POST",
                    data:{
                        rating_list : rating_list
                    },
                    url:"ajax/update_rating_sequence.php",
                    success:function(response){
                       
                    }
               });
            }
        }
    );

    $("#btn_add_competency").click(function(){
        if($("#txt_competency").val()!=""){
            $.ajax({
                type:"POST",
                data:{
                    competency : $("#txt_competency").val()
                },
                url:"ajax/add_competency.php",
                success:function(response){
                    location.reload();
                }
            });
        }
    });

    $("body").on("click",".btn_edit_competency",function(){
        var li_parent = $(this).parent().parent();
        competency_id = li_parent.data("competency_id");
        competency_description = li_parent.children("span:first");
        $("#txt_update_competency").val(competency_description.text());
        $("#dialog_update_competency").modal("show");   
    });

    $("#btn_update_competency").click(function(){
        if($("#txt_update_competency").val()!=""){
            $.ajax({
                type:"POST",
                data:{
                    competency_id   : competency_id,
                    description     : $("#txt_update_competency").val()
                },
                url:"ajax/update_competency_description.php",
                success:function(response){
                    competency_description.text($("#txt_update_competency").val());
                    $("#dialog_update_competency").modal("hide");
                }
            });
        }
    });

    $("body").on("click",".btn_deactivate_competency",function(){
        var li_parent = $(this).parent().parent();
        competency_id = li_parent.data("competency_id");
        $.ajax({
            type:"POST",
            data:{
                competency_id : competency_id
            },
            url:"ajax/deactivate_competency.php",
            success:function(response){
                location.reload();
            }
        });
    });

    $("#btn_add_rating").click(function(){
        if($("#txt_rating").val()!=""){
            $.ajax({
                type:"POST",
                data:{
                    rating : $("#txt_rating").val()
                },
                url:"ajax/add_rating.php",
                success:function(response){
                    location.reload();
                }
            });
        }
    });


    $("body").on("click",".btn_edit_rating",function(){
        var li_parent = $(this).parent().parent();
        rating_id = li_parent.data("rating_id");
        rating_description = li_parent.children("span:first");
        $("#txt_update_rating").val(rating_description.text());
        $("#dialog_update_rating").modal("show");   
    });

    $("#btn_update_rating").click(function(){
        if($("#txt_update_rating").val()!=""){
            $.ajax({
                type:"POST",
                data:{
                    rating_id   : rating_id,
                    description : $("#txt_update_rating").val()
                },
                url:"ajax/update_rating_description.php",
                success:function(response){
                    rating_description.text($("#txt_update_rating").val());
                    $("#dialog_update_rating").modal("hide");
                }
            });
        }
    });

    $("body").on("click",".btn_deactivate_rating",function(){
        var li_parent = $(this).parent().parent();
        rating_id = li_parent.data("rating_id");
        $.ajax({
            type:"POST",
            data:{
                rating_id : rating_id
            },
            url:"ajax/deactivate_rating.php",
            success:function(response){
                location.reload();
            }
        });
    });

});
</script>

</body>
</html>