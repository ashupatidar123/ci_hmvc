<div class="container-fluid">
    <h1 class="mt-4">Admin Profile</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?=base_url('webpanel/');?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <!-- <h2>Vertical (basic) form</h2> -->
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" name="mobile" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>About Us</label>
                            <input type="text" name="about" class="form-control" autocomplete="off">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>                
            </form>
        </div>
    </div>
</div>