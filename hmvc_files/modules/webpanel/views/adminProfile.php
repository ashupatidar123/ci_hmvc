<div class="container-fluid">
    <h1 class="mt-4">Admin Profile</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?=base_url('webpanel/');?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <?php 
                if(!empty($this->session->flashdata('response'))){ ?>
                    <div class="hideFlash <?=$this->session->flashdata('response')['alert'];?>">
                        <strong> <?=$this->session->flashdata('response')['message'];?></strong> 
                    </div>
            <?php }?>
            <form action="<?=base_url('webpanel/update/updateProfile');?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" autocomplete="off" value="<?= $record['name'];?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" autocomplete="off" value="<?= $record['email'];?>">
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" name="mobile" class="form-control" autocomplete="off" value="<?= $record['mobile'];?>">
                        </div>
                        <div class="form-group">
                            <label>About Us</label>
                            <textarea rows='5' name="about" class="form-control"><?= $record['location_url'];?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>                
            </form>
        </div>
    </div>
</div>