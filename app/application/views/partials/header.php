<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=base_url("assets/css/styles.css");?>">
    <title><?=$title;?></title>
</head>
<body>


<?php if($this->session->flashdata('errors')){
        foreach($this->session->flashdata('errors') as $error){?>
<p><?=$error;?></p>
<?php } 
} ?>

<?php if($this->session->flashdata('success')){?>
    <p><?=$this->session->flashdata('success');?></p>
<?php } ?>




