<?php 
require_once "model/Backend.php";


$model = new Backend;

// list nha xe

$arrTotal = $model->getListCode(1, -1, -1);


?>



<div class="row">



    <div class="col-md-8">

 <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=promotion_code&act=list'">Danh sách CODE</button>

        <form method="post" action="controller/Mailcode.php">            



        <!-- Custom Tabs -->



       



        <div style="clear:both;margin-bottom:10px"></div>



         <div class="box-header">



                <h3 class="box-title">Tạo mới danh sách email nhận promotion code</h3>



            </div><!-- /.box-header -->



        <div class="nav-tabs-custom"> 


            <div class="button"> 
                <div class="form-group">

                        <label>CODE<span class="required"> ( * ) </span></label>

                        <select class="form-control required" name="code_id" id="code_id">

                            <option value="0">---chọn---</option> 

                             <?php if(!empty($arrTotal['data'])){

                                foreach ($arrTotal['data'] as $value) {

                                    ?>

                                    <option value="<?php echo $value['code_id']; ?>"><?php echo $value['code']; ?></option> 

                                    <?php 

                                }}

                                ?>                           

                        </select>

                </div>                            
                <div class="form-group">
                    <label>List email <span class="required"> ( * ) </span></label>                        
                    <textarea rows="10" class="form-control required" name="list_email"></textarea>
                </div>
                <p style="font-size:18px">Lưu ý : list email cách nhau bằng dấu ";" <br />
                    VD : <span style="color:red">email_1@gmail.com; email_2@gmail.com; email_3@gmail.com</span>
                </p>
              

            </div>

            <div class="button">

                <button class="btn btn-primary btnSave" type="submit">Save</button>

                <button class="btn btn-primary" type="button" onclick="location.href='index.php?mod=promotion_code&act=list'">Cancel</button>

            </div>

        </div><!-- nav-tabs-custom -->



    </form>



    </div><!-- /.col --> 



</div>