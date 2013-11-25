<?php


class SWAT
{
  
  /**
   *
   * Parse the core metadata from SWAT model files
   */
  public function parse_metadata($form, &$form_state, $swat_path){
    
    // intialize variables
    $duration = null;
    $str_start = null;
    $str_end = null;
    $time_unit = null;
    $date_created = null;
    $model_desc = null;
    $creation_date = null;
    
    $i = 1;
    
    // open the main swat file
    $handle = @fopen($swat_path . '/file.cio','r');
    if ($handle){
      while (($buffer = fgets($handle, 4096)) !== false){
        
        switch($i){
       
          case 2:
            // get model description
            $str = explode(":", $buffer);
            $model_desc = trim($str[1]);
            break;
          case 4:
            // get creation date
            $str = explode(":", $buffer);
            $creation_date = substr(trim($str[0]),0,-2);
            break;
          case 8:
            // get simulation year span
            $str = explode("|", $buffer);
            $duration = intval(trim($str[0]));
            break;
          case 9:
            // get simulation start year
            $str = explode("|", $buffer);
            $st_year = intval(trim($str[0]));
            break;
          case 10:
            // get simulation start julien day
            $str = explode("|", $buffer);
            $start_julian_day = intval(trim($str[0])) - 1;
            break;
          case 11:
            // get simulation end julien day
            $str = explode("|", $buffer);
            $end_julian_day = ($duration * intval(trim($str[0]))) - 1;
            break;
          case 59:
            // get output print interval
            $str = explode('|',$buffer);
            $interval_code = intval(trim($str[0]));
            if ($interval_code == 0){$time_unit = 'monthly';}
            elseif ($interval_code == 1){$time_unit = 'daily';}
            else {$time_unit = 'yearly';}
            break;
        }
        // increment the line counter
        $i++;
        
      }
      
      // build start datetime
      $start = new DateTime('1/1/' . $st_year);
      $start->add(new DateInterval('P'.$start_julian_day.'D'));
      $str_start = $start->format('m/d/Y');
          
      // build end datetime
      $end = $start;
      $end->add(new DateInterval('P'.$end_julian_day.'D'));
      $str_end = $end->format('m/d/Y');

   
    }
    
    
    // set form values --> $form_state['complete form']['post_fieldset']['post_id']['#value'] = $my_value;
    $form_state['input']['field_temporal_begin']['und'][0]['value'] = $str_start;
    $form_state['input']['field_temporal_end']['und'][0]['value'] = $str_end; 
    $form_state['input']['field_id_description']['und'][0]['value'] = $model_desc;
    $form_state['input']['field_temporal_interval']['und'][0]['value'] = $time_unit;
    $form_state['input']['field_dev_create_date']['und'][0]['value'] = $creation_date;
    
  }

  
  
  /**
   *
   * Return a single output data series for plotting
   */
  public function get_single_output($node, $model_path){
    
    
    // get simulation start time
    $begin = $node->field_temporal_begin['und'][0]['safe_value'];
    $start_dt = datetime::createfromformat('m/d/Y H:i:s',$begin.' 00:00:00');
    
    // get output values
    $volume_flow = array();
    $date = array();
    $values = array();
    $i = 1;
    $handle = @fopen($model_path . '/output.rch','r');
    if ($handle){
      while (($buffer = fgets($handle, 4096)) !== false){
        if($i >= 10){

          $name = trim(substr($buffer,0,10));                              
          $mon = trim(substr($buffer,22,3));
          $outflow = floatval(trim(substr($buffer,51,10)));

          // add reach to volume flow array
          if (!array_key_exists($name,$volume_flow)){
            
          }
          
          
          // build date
          if ($node->field_temporal_interval['und'][0]['safe_value'] == 'daily'){
            $dt = clone $start_dt;
            $dt->add(new DateInterval('P'.$mon.'D'));
            $dt = date_format($dt, 'm/d/Y H:i');
          }

          // add values to array
          if (array_key_exists($name, $values)){
            array_push($values[$name],array($dt, $outflow));
            //array_push($values[$name]['vals'], $outflow);
            //array_push($values[$name]['dates'],$dt);
            $volume_flow[$name] += $outflow;
          }
          else {
            $values[$name] = array(array($dt, $outflow));
            //$values[$name]['vals'] = array($outflow);
            //$values[$name]['dates'] = array($dt);
            $volume_flow[$name] = 0.0;
          }


        }
        $i++;
      }
    }
    
    // return only the flow at the outlet (assumed to have the largest volume of outflow)
    $outlet = array_keys($volume_flow, max($volume_flow));
    
    return $values[$outlet[0]];
  }
}