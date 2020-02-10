<?php echo $header; 
$registry = new Registry();
$ZasilkovnaMag = new ControllerShippingZasilkovnaMag($registry);
?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/shipping.png');">Zásilkovna</h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>

  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table>
          <tr>            
            <td>Název dopravy</td>
            <td>Cena</td>
            <td>Zdarma od</td>
            <td>Cílová země</td>
            <td>Zobrazit pobočky</th>
            <td>Zobrazit</th>
          </tr>
        <?php
        for($i=0;$i<$ZasilkovnaMag->_servicesCnt;$i++) { ?>                  
          <tr>            
            <td style="align:left;">
                  
              <?php            
                $input_field_name = "ZasilkovnaMag_title_".$i;                       
              ?> 
              <input type="text" name="<?php echo $input_field_name;?>" value="<?php echo ${$input_field_name};?>" />

            </td>            
            <td>                 
              <?php        
                $input_field_name = "ZasilkovnaMag_price_".$i;                       
              ?> 
              <input type="text" name="<?php echo $input_field_name;?>" value="<?php echo ${$input_field_name};?>" />
            </td>   
			
            <td>                 
              <?php        
                $input_field_name = "ZasilkovnaMag_freeover_".$i;                       
              ?> 
              <input type="text" name="<?php echo $input_field_name;?>" value="<?php echo ${$input_field_name};?>" />
            </td>

            <td>                 
              <?php $input_field_name = "ZasilkovnaMag_destination_".$i;  ?>
              
                <select name="<?php echo $input_field_name;?>">

              <?php     
              echo ${$input_field_name};
              foreach ($this->countries as $country_code => $country) {
                $selected="";
                if(${$input_field_name}==$country_code){
                  $selected=' selected="selected" ';
                }
                ?>

                <option value="<?php echo $country_code;?>" <?php echo $selected; ?>><?php echo $country;?></option>
              <?php
              }                          
              ?> 
                </select>
              
            </td>
            <td>
              <?php
                $input_field_name = "ZasilkovnaMag_branches_enabled_".$i;
              ?>
              <select class="form-control" name="<?php echo $input_field_name;?>">
              <?php if (${$input_field_name}) { ?>
                <option value="1" selected="selected">ano</option>
                <option value="0">ne</option>
                <?php } else { ?>
                <option value="1">ano</option>
                <option value="0" selected="selected">ne</option>
              <?php } ?>
            </td>
            <td>                 
              <?php            
                $input_field_name = "ZasilkovnaMag_enabled_".$i;                                       
              ?> 
              <select name="<?php echo $input_field_name;?>">
              <?php if (${$input_field_name}) { ?>
                <option value="1" selected="selected">ano</option>
                <option value="0">ne</option>
                <?php } else { ?>
                <option value="1">ano</option>
                <option value="0" selected="selected">ne</option>
              <?php } ?>
            </select>
            </td> 

          </tr>            
          <?php            
        }    
        ?>
      </table>
      <table class="form">
        <tr>
          <td><b>Povolit Modul:</b></td>
          <td><select name="ZasilkovnaMag_status">
              <?php if ($ZasilkovnaMag_status) { ?>
              <option value="1" selected="selected">ano</option>
              <option value="0">ne</option>
              <?php } else { ?>
              <option value="1">ano</option>
              <option value="0" selected="selected">ne</option>
              <?php } ?>
            </select></td>
        </tr>      
        <tr>
          <td><b>API klíč:</b></td>
          <td> <?php            
                $input_field_name = "ZasilkovnaMag_api_key";                      
              ?> 
              <input type="text" size="17" name="<?php echo $input_field_name;?>" value="<?php echo ${$input_field_name};?>" />
              <?php
              if(strlen(${$input_field_name})!=16){
                echo '<p style="color:red; font-weight:bold;">Zadajte správný api klíč! (Získáte na <a href="http://www.ZasilkovnaMag.cz/muj-ucet">ZasilkovnaMag.cz/muj-ucet</a></p>';
              }
              ?>
          </td>          
        </tr>        
          <td>Daň:</td>
          <td><select name="ZasilkovnaMag_tax_class_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($tax_classes as $tax_class) { ?>
              <?php if ($tax_class['tax_class_id'] == $ZasilkovnaMag_tax_class_id) { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td>Maximální hmotnost:</td>
          <td>
              <?php $input_field_name = "ZasilkovnaMag_weight_max"; ?>
              <input type="text" size="17" name="<?php echo $input_field_name;?>" value="<?php echo isset(${$input_field_name}) ? ${$input_field_name} : '';?>" />
          </td>
        </tr>
        <tr>
          <td>Geo zone</td>
          <td><select name="ZasilkovnaMag_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $ZasilkovnaMag_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
      
        <tr>
          <td>Priorita:</td>
          <td><input type="text" name="ZasilkovnaMag_sort_order" value="<?php echo $ZasilkovnaMag_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>