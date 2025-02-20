<?php include('includes/header.php'); ?>
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Order Details</li>
          </ol>
        </nav>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        User Lists
                        <a href="users-create.php" class="btn btn-primary float-end">Add Users</a>
                    </h4>
                </div>
                <div class="card-body">

                    <?= alertMessage(); ?>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            $users=getAll('users');
                            if(mysqli_num_rows($users)>0)
                            {
                                foreach($users as $userItem)
                                {
                                    ?>
                                    <tr>
                                        <td><?= $userItem['id']; ?></td>
                                        <td><?= $userItem['username']; ?></td>
                                        <td><?= $userItem['email']; ?></td>
                                        <td><?= $userItem['role']; ?></td>
                                        <td>
                                            <a href="users-edit.php?id=<?= $userItem['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                            <a href="users-delete.php?id=<?= $userItem['id']; ?>" 
                                                class="btn btn-danger btn-sm mx-2"
                                                onclick="return confirm('Are you sure you want to delete this data?')"
                                                >
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td colspan="7">No Record Found</td>
                                </tr>
                                <?php
                            }
                            ?>
                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

<?php include('includes/footer.php'); ?>