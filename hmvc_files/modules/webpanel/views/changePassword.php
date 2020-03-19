<div class="container-fluid">
    <h1 class="mt-4">Change Password</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?=base_url('webpanel/');?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Password</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <!-- <h2>Vertical (basic) form</h2> -->
            <?php 
                if(!empty($this->session->flashdata('response'))){ ?>
                    <div class="hideFlash <?=$this->session->flashdata('response')['alert'];?>">
                        <strong> <?=$this->session->flashdata('response')['message'];?></strong> 
                    </div>
            <?php }?>
            <form method="post" action="<?=base_url('webpanel/update/updatePassword');?>" onsubmit="return validateForm('updatePassword')">
                <div class="row">

                    <div class="col-md-6">                        
                        <div class="form-group">
                            <input type="text" name="old_password" placeholder="Enter old password" class="form-control" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" name="new_password" placeholder="Enter new password" class="form-control" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <!-- <label>Re Enter Password</label> -->
                            <input type="text" name="confirm_password" placeholder="Enter confirm password" class="form-control" autocomplete="off" required="">
                            <span id="cnfm" class="text-danger"></span> 
                        </div>                              

                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <div class="col-md-6">
                        <img class="mb-4 img-error" src="<?=base_url('uploads/logo/password.png')?>"/>
                    </div>
                </div>                
            </form>
        </div>
    </div>
</div>