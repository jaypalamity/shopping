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
  <h2>Detail Page</h2>

    <div class="form-group">
      <label for="email">Name:</label>
     <?php echo $item->name; ?>
    </div>
    <div class="form-group">
      <label for="pwd">Price:</label>
     <?php echo $item->price; ?>
    </div>
    <div class="form-group">
      <label for="pwd">Item image:</label>   
      <img src="<?php echo base_url('assets/uploads'); ?>/<?php echo $item->item_image ?>" height="70px; width:70px;">
    </div>
   
  
</div>

</body>
</html>
