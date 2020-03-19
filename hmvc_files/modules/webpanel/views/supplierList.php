    <div class="container-fluid">
        <h1 class="mt-4"></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Supplier details</li>
        </ol>
        
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Supplier List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Products</th>
                                <th>Location</th>
                                <th>Drawings</th>
                                <th>List of require</th>
                                <th>Register date</th>
                                <td>Action</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            if(!empty($record)){

                            
                                $sno = 1;
                                foreach($record as $key=>$row){                                
                                $ext1 = checkImageExtension($row['file_ext1']);
                                $ext2 = checkImageExtension($row['file_ext2']);
                                $user_status = ($row['user_status']==1)?'Active':'Deactivated';

                                $user_id = $row['user_id'];
                                $pName = $this->comman_controller->productNameGet($user_id);
                            ?>
                                <tr>
                                    <td><?=$sno++;?></td>
                                    <td><?=$row['name'];?></td>
                                    <td><?=$row['email'];?></td>
                                    <td><?=$row['mobile'];?></td>
                                    <td><?=$pName;?></td>
                                    <td>
                                        <a target="_blank" href="<?=$row['location_url'];?>">CLICK</a>
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($row['file_name1']) && ($ext1=='image')){?>
                                            <a target="_blank" href="<?=base_url('uploads/').$row['file_name1'];?>">
                                                <img src="<?=base_url('uploads/').$row['file_name1'];?>" width="90" height="80">
                                            </a>
                                        <?php 
                                        }else if(!empty($row['file_name1'])){?>
                                           <a target="_blank" href="<?=base_url('uploads/').$row['file_name1'];?>">PDF/DOC</a> 
                                        
                                        <?php
                                        }else if(empty($row['file_name1'])){?>
                                           <img target="_blank" src="<?=base_url('uploads/logo/no_image.png');?>" width="90" height="80">
                                        <?php
                                        }

                                        ?>    
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($row['file_name2']) && ($ext2=='image')){?>
                                            <a target="_blank" href="<?=base_url('uploads/').$row['file_name2'];?>">
                                                <img src="<?=base_url('uploads/').$row['file_name2'];?>" width="90" height="80">
                                            </a>
                                        <?php 
                                        }else if(!empty($row['file_name2'])){?>
                                           <a target="_blank" href="<?=base_url('uploads/').$row['file_name2'];?>">PDF/DOC</a> 
                                        
                                        <?php
                                        }else if(empty($row['file_name2'])){?>
                                           <img target="_blank" src="<?=base_url('uploads/logo/no_image.png');?>" width="90" height="80">
                                        <?php
                                        }

                                        ?>   
                                    </td>
                                    <td><?=dateFormat($row['register_date']);?></td>
                                    <td><?=$user_status;?></td>
                                </tr>
                            <?php
                            }  } ?>    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>