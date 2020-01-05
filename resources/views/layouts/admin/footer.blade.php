<footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">Parkiez</a>.</strong> All rights reserved.
</footer>

<!-- JS -->
<!-- jQuery 2.1.4 -->
<script src="/js/plugin/jQuery-2.1.4.min.js"></script>
<script src="/js/plugin/jquery.validate.1.15.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="/js/plugin/bootstrap.min.js"></script>
<!-- DATATABLE-->
<script src="/js/plugin/jquery.dataTables.min.js"></script>
<script src="/js/plugin/dataTables.bootstrap.min.js"></script>
<script src="/js/plugin/fnReloadAjax.js"></script>
<!-- SlimScroll -->
<script src="/js/plugin/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/js/plugin/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="/js/plugin/app.min.js"></script>

<script>
<?php
if (isset($activeMenuId)) {
    if (is_array($activeMenuId)) {
        foreach ($activeMenuId as $elementId) {
            ?>
                $('#<?php echo $elementId; ?>').addClass('active');
            <?php
        }
    } else {
        ?>
            $('#<?php echo $activeMenuId; ?>').addClass('active');
        <?php
    }
}
?>
$(document).on('click','ul.sidebar-menu li a', function() {
    $('ul.sidebar-menu li').removeClass('active');
    if($('ul.sidebar-menu li ul').hasClass("menu-open")){
        <?php
    if (isset($activeMenuId)) {
        if (is_array($activeMenuId)) {
            foreach ($activeMenuId as $elementId) {
                ?>
                    $('#<?php echo $elementId; ?>').addClass('active');
                <?php
            }
        } else {
        ?>
            $('#<?php echo $activeMenuId; ?>').addClass('active');
        <?php
        }
    }
?>
     }
});
</script> 