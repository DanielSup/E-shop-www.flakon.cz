<form action="<?php echo $action; ?>" method="post">
<?php 
print borgun_form::lines($borgun);
?>
  <div class="buttons">
    <div class="right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="button" />
    </div>
  </div>
</form>