<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="container">
            <h2>Add Item Detail</h2>
            <?php if ($this->session->flashdata('message')) { ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('message') ?> </div>

            <?php } if ($this->session->flashdata('msg-error')) { ?>
                <div class="alert alert-danger"> <?= $this->session->flashdata('msg-error'); ?> </div>
            <?php } ?>
            <form action="<?php echo base_url('index.php/items/add'); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" value="" id="name" placeholder="Enter Name" name="name">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="test" class="form-control" value="" id="price" placeholder="Enter Price" name="price">
                </div> 

                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input type="file" class="form-control-file" id="exampleInputFile" name="item_image" aria-describedby="fileHelp">

                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>

    </body>
</html>
