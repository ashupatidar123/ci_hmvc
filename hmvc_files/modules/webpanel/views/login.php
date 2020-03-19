<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin Login</title>
        <link href="<?=base_url('assets/admin/css/styles.css');?>" rel="stylesheet" />
        <script src="<?=base_url('assets/comman/js/jquery-3.4.1.min.js');?>"></script>
        <script src="<?=base_url('assets/admin/js/mycustom.js');?>"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <?php 
                                            if(!empty($this->session->flashdata('response'))){ ?>
                                                <div class="hideFlash <?=$this->session->flashdata('response')['alert'];?>">
                                                    <strong> <?=$this->session->flashdata('response')['message'];?></strong> 
                                                </div>
                                        <?php }?>
                                        <form method="post" action="<?=base_url('webpanel/login/login_auth/');?>" onsubmit="return validateForm('adminLogin')">
                                            <div class="form-group">
                                                <label class="small mb-1">Email</label>
                                                <input name="email" class="form-control py-4" type="email" placeholder="Enter email" autocomplete="off"/>
                                                <span id="eml" class="text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1">Password</label>
                                                <input name="password" class="form-control py-4" type="password" placeholder="Enter password" autocomplete="off"/>
                                                <span id="pass" class="text-danger"></span>
                                            </div>
                                            <div class="form-group" style="display: none;">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox"/>
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <!-- <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2019</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div> -->
        </div>
    </body>
</html>
