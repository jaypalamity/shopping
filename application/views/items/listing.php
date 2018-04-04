<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script language="JavaScript">
            function chkAll(frm, arr, mark) {
                for (i = 0; i <= frm.elements.length; i++) {
                    try {
                        if (frm.elements[i].name == arr) {
                            frm.elements[i].checked = mark;
                        }
                    } catch (er) {
                    }
                }
            }
        </script>

    </head>
    <body>
        <div class="container">
            <h2>Item List</h2>
            <p><a href="<?php echo base_url('items/create'); ?>">Add</a></p> 

            <p><a href="<?php echo base_url('backoffice/login/logout'); ?>">Logout</a></p> 
            <?php if ($this->session->flashdata('message')) { ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('message') ?> </div>

            <?php } if ($this->session->flashdata('msg-error')) { ?>
                <div class="alert alert-danger"> <?= $this->session->flashdata('msg-error'); ?> </div>
            <?php } ?>
            <form name="deleteSelected" name="foo" action="<?php echo base_url('items/deleteSelected'); ?>" method="post">
                <table class="table">
                    <thead>
                        <tr>

<!--                            <th><input type="checkbox" class="checkall"></th>-->
                            <th><input type="checkbox" name="ca" onClick="chkAll(this.form, 'chkValue[]', this.checked)"></th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Cart</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($articles)) { ?>
                            <?php foreach ($articles as $item) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" name='chkValue[]'  value="<?php echo $item->id ?>"></td> 
                                    <td><?php echo $item->name ?></td>

                                    <td><?php echo $item->price ?></td>
                                    <td><img src="<?php echo base_url('assets/uploads'); ?>/<?php echo $item->item_image ?>" height="70px; width:70px;"></td>
                                    <td><a href="<?php echo base_url('index.php/items/addtocart'); ?>?id=<?php echo $item->id; ?>">Add To Cart</a></td>
                                    <td><a href="<?php echo base_url('index.php/items/view'); ?>/<?php echo $item->id ?>">View</a></td>
                                    <td><a href="<?php echo base_url('index.php/items/edit'); ?>/<?php echo $item->id ?>">Edit</a></td>
                                    <td><a href="<?php echo base_url('index.php/items/delete'); ?>/<?php echo $item->id ?>">Delete</a></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td>No Data found</td></tr>';
                        }
                        ?>

                    </tbody>
                </table>
                <input type="submit" name="deleteAll" value="Delete">
            </form>

            <?= $this->pagination->create_links(); ?>
        </div>
    </body>
</html>
