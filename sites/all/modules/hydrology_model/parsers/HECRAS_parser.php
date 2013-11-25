<?php

class HECRAS
{
  
  /**
   *
   * Parse the core metadata from SWAT model files
   */
  public function parse_metadata($form, &$form_state, $model_path){
    
    // intialize variables
    $duration = null;
    $str_start = null;
    $str_end = null;
    $time_unit = null;
    $date_created = null;
    $model_desc = null;
    $creation_date = null;
    
    
    // find all files
    $files = array();
    $filenames = glob($model_path."/*");
    foreach ($filenames as $fn){
      $files[] = $fn;
    }
    
    // get the project file
    $prj = $files[key(preg_grep('/.prj$/',$files))];
    
    // read the prj file
    $handle = @fopen($prj,'r');
    $i = 1;
    if ($handle){
      while (($buffer = fgets($handle, 4096)) !== false){
        
        switch($i){
          case 16:
            // get model description
            $buffer = fgets($handle, 4096);
                  
        }
        $i += 1;
      }
   }
        
//        switch($i){
//       
//          case 2:
//            // get model description
//            $str = explode(":", $buffer);
//            $model_desc = trim($str[1]);
//            break;
//          case 4:
//            // get creation date
//            $str = explode(":", $buffer);
//            $creation_date = substr(trim($str[0]),0,-2);
//            break;
//          case 8:
//            // get simulation year span
//            $str = explode("|", $buffer);
//            $duration = intval(trim($str[0]));
//            break;
//          case 9:
//            // get simulation start year
//            $str = explode("|", $buffer);
//            $st_year = intval(trim($str[0]));
//            break;
//          case 10:
//            // get simulation start julien day
//            $str = explode("|", $buffer);
//            $start_julian_day = intval(trim($str[0])) - 1;
//            break;
//          case 11:
//            // get simulation end julien day
//            $str = explode("|", $buffer);
//            $end_julian_day = ($duration * intval(trim($str[0]))) - 1;
//            break;
//          case 59:
//            // get output print interval
//            $str = explode('|',$buffer);
//            $interval_code = intval(trim($str[0]));
//            if ($interval_code == 0){$time_unit = 'monthly';}
//            elseif ($interval_code == 1){$time_unit = 'daily';}
//            else {$time_unit = 'yearly';}
//            break;
//        }
//        // increment the line counter
//        $i++;
//        
//      }
      
//      // build start datetime
//      $start = new DateTime('1/1/' . $st_year);
//      $start->add(new DateInterval('P'.$start_julian_day.'D'));
//      $str_start = $start->format('m/d/Y');
//          
//      // build end datetime
//      $end = $start;
//      $end->add(new DateInterval('P'.$end_julian_day.'D'));
//      $str_end = $end->format('m/d/Y');
//
//   
//    }
    
    
//    // set form values --> $form_state['complete form']['post_fieldset']['post_id']['#value'] = $my_value;
//    $form_state['input']['field_temporal_begin']['und'][0]['value'] = $str_start;
//    $form_state['input']['field_temporal_end']['und'][0]['value'] = $str_end; 
//    $form_state['input']['field_id_description']['und'][0]['value'] = $model_desc;
//    $form_state['input']['field_temporal_interval']['und'][0]['value'] = $time_unit;
//    $form_state['input']['field_dev_create_date']['und'][0]['value'] = $creation_date;
    
  }
}