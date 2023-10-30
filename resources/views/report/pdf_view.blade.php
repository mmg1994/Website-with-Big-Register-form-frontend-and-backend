<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PDF View</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<body>

<div>
    <?php
    $profileImage = isset($_GET['profile_image']) ? $_GET['profile_image'] : '';
    $imagePath = public_path('storage/' . $profileImage);
    $imageData = base64_encode(file_get_contents($imagePath));
    $imageSrc = 'data:images/jpeg,png,jpg,gif;base64,' . $imageData;
    ?>
    <img src="<?php echo $imageSrc; ?>" alt="Profile Image" class="profile-image">
</div>

<div>
    <div>
        <h2>Informations client</h2>
    </div>

    <div class="form-group row">
        <label for="id_iv" class="col-sm-2 col-form-label">ID:</label>
        <div class="col-sm-10">
            <input type="text" id="id_iv" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <label for="name_iv" class="col-sm-2 col-form-label">Name:</label>
        <div class="col-sm-10">
            <input type="text" id="name_iv" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>" class="form-control">
        </div>
    </div>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>