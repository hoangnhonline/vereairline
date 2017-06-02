<?php 

if(isset($_GET['code_id'])){

    $code_id = (int) $_GET['code_id'];

    require_once "model/Backend.php";

    $model = new Backend;

    $detail = $model->getDetailCode($code_id);

}
?>

<div class="row">

    <div class="col-md-8">

         <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=promotion_code&act=list'">Danh sách</button>
        <form method="post" action="controller/Code.php">            

        <!-- Custom Tabs -->

       

        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">    
         <div class="box-header">

                <h3 class="box-title"><?php echo ($code_id > 0) ? "Cập nhật" : "Tạo mới" ?> promotion code <?php echo ($code_id > 0) ? " : ".$detail['title'] : ""; ?></h3>

                <?php if($code_id> 0){ ?>

                <input type="hidden" value="<?php echo $code_id; ?>" name="code_id" />

                <?php } ?>

            </div><!-- /.box-header -->

        <div class="box-body">            
            <div class="form-group">

                    <label>Mã <span class="required"> ( * ) </span></label>

                    <input type="text" name="code" class="form-control required" value="<?php echo isset($detail['code'])  ? $detail['code'] : "" ?>">

            </div>    
            <div class="form-group">

                <label>Loại <span class="required"> ( * ) </span></label>

                <select class="form-control required" name="type" id="type">

                    <option value="0">---chọn---</option>

                    <option value="1" <?php echo ($detail['type']==1) ? "selected" : ""; ?>>Giảm giá</option>

                    <option value="2" <?php echo ($detail['type']==2) ? "selected" : ""; ?>>Trừ tiền</option>

                   <!-- <option value="3" <?php echo ($detail['type']==3) ? "selected" : ""; ?>>Quà tặng</option>-->

                </select>

            </div>    
            
            <div class="form-group">

                <label>Giá trị <span class="required"> ( * ) </span></label>                        

                <textarea rows="5" class="form-control required" name="code_value"><?php if(isset($detail['code_value'])) echo $detail['code_value']; ?></textarea>

            </div>
            <div class="form-group">

                    <label>Số lượng <span class="required"> ( * ) </span></label>

                    <input type="text" name="amount" class="form-control required" value="<?php echo isset($detail['amount'])  ? $detail['amount'] : "" ?>">

            </div>
            <div class="form-group">

                <label>Ghi chú </label>                        

                <div>
                    <p>Loại = "Giảm giá"  thì nhập Value như VD sau : <span style="color:red">30%</span> </p>
                    <p>Loại = "Trừ tiền"  thì nhập Value như VD sau : <span style="color:red">30000</span></p>
                    
                </div>

            </div>
        
             
                  

            <div class="button">

                <button class="btn btn-primary btnSave" type="submit">Save</button>

                <button class="btn btn-primary" type="button" onclick="location.href='index.php?mod=promotion_code&act=list'">Cancel</button>

            </div>

           

        </div><!-- nav-tabs-custom -->
        </div>
    </form>

    </div><!-- /.col --> 

</div>