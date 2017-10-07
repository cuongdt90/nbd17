<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div class="nbd-gallery-con">
    <div class="nbd-sidebar">
        <?php include_once('sidebar.php'); ?>
    </div>
    <div class="nbd-list-designs">
        <div class="nbd-design-filter">
            //show filter
        </div>
        <?php include_once('gallery.php'); ?>
    </div>  <!-- End. list designs -->    
</div>    
<style>
    .nbd-gallery header.entry-header {
        height: 300px;
        background-color: rgba(118,183,166,0.95);
    }
    .nbd-gallery header h1{
        height: 100%;
        line-height: 300px;
        background-image: url('<?php echo NBDESIGNER_ASSETS_URL . 'images/gallery.png' ?>');
        transform: none;
        background-repeat: repeat;          
        text-align: center;
        color: #fff;
        text-transform: uppercase;
        font-weight: bold;
    }
    .nbd-gallery-con {
        padding-top: 30px;
        max-width: 1200px;
        margin: 0 auto;        
    }
    .nbd-sidebar, .nbd-list-designs {
        float:  left; 
    }
    .nbd-sidebar-con {
        width: 220px;
        border: 1px solid #E6E6E6;
        border-radius: 2px;   
        margin-bottom: 15px;
    }
    .nbd-list-designs {
        width: calc(100% - 240px);
        margin-left: 20px;
    }    
    .nbd-sidebar-h3 {
        padding: 5px 14px;
        border-bottom: 1px dashed #e6e6e6;    
        margin: 0;
    }
    .nbd-sidebar-con ul {
        margin: 0 0 0 15px;
    }
    .nbd-sidebar-con > ul{
        margin-bottom: 15px;
        margin-top: 15px;
    }    
    .nbd-sidebar-con ul li {
        list-style: none;
    }
    .nbd-tag {
        display: inline-block;
        margin: 0 10px 10px 0;
        padding: 0 25px 0 20px;
        line-height: 30px;
        border-radius: 2px;
        background-color: #ddd;
        color: #34495e;
        font-weight: 300;
        font-size: 14px;
        -moz-transition: all ease .3s;
        -o-transition: all ease .3s;
        -webkit-transition: all ease .3s;
        transition: all ease .3s;
        position: relative;        
    }
    .nbd-tag:before {
        background: #f4f4f4;
        border-radius: 10px;
        box-shadow: inset 0 1px rgba(0,0,0,.25);
        content: '';
        height: 8px;
        left: 6px;
        position: absolute;
        width: 8px;
        top: 10px;
    }
    .nbd-tag:after {
        background: 0 0;
        border-bottom: 15px solid #fff;
        border-left: 10px solid #ddd;
        border-top: 15px solid #fff;
        content: '';
        position: absolute;
        -moz-transition: all ease .3s;
        -o-transition: all ease .3s;
        -webkit-transition: all ease .3s;
        transition: all ease .3s;
        right: 0;
        top: 0;
    }
    .nbd-tag:hover {
        color: #0099fe;
        background-color: #0c8ea7;
        color: #fff;
    }    
    .nbd-tag:hover:after {
        border-left: 10px solid #0c8ea7;
    }    
</style>