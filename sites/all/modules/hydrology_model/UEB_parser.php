<?php

class UEB
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
    
    $start_dt = null;
    $end_dt = null;

    // get all ueb model file paths
    $files = $this->get_files_in_dir($model_path);
    
    
    // get the inputcontrol.dat path
    $inputcontrol = $files[key(preg_grep('/inputcontrol.dat$/',$files))];
    
    // parse the input control file
    $handle = @fopen($inputcontrol,'r');
    $i = 1;
    if ($handle){
      while (($buffer = fgets($handle, 4096)) !== false){
        
        switch($i){
          case 2:
            // get simulation start
            $str_start = DateTime::createFromFormat('Y m d H',preg_replace('!\s+!', ' ',substr($buffer,0,13)))->format('m/d/Y');
            break;
            // should convert this to utc ?
          case 3:
            // get simulation end
            $str_end = DateTime::createFromFormat('Y m d H',preg_replace('!\s+!', ' ',substr($buffer,0,13)))->format('m/d/Y');
            break;
            // should convert this to utc ?
          
          case 4:
            // get time step in seconds
            $time_unit = intval(trim(substr($buffer,0,4)));
            
            // convert time unit from hours into seconds
            $time_unit *= 3600;
            
            break;
            
          case 5:
            // get utc offset
            $offset = intval(trim(substr($buffer,0,4))); 
            break;
        }
        $i += 1;
      }
   }
   @fclose($handle);
        
   // get the model control .dat path
   $reserved_controls = array("aggregateouputcontrol", "inputcontrol","outputcontrol");
   $modelcontrols = preg_grep('/ontrol.dat$/',$files);
   $modelcontrol = null;
   foreach($modelcontrols as $m){
     $file_name = array_pop(explode('/', $m));
     if (!in_array($file_name,$reserved_controls)){
       $modelcontrol = $m;
       break;
     }
   }
   
    // parse the input control file
    $handle = @fopen($modelcontrol,'r');
    $i = 1;
    if ($handle){
      $model_desc = fgets($handle, 4096);
      }
    @fclose($handle);

    
    // set form values --> $form_state['complete form']['post_fieldset']['post_id']['#value'] = $my_value;
    $form_state['input']['field_temporal_begin']['und'][0]['value'] = $str_start;
    $form_state['input']['field_temporal_end']['und'][0]['value'] = $str_end; 
    $form_state['input']['field_id_description']['und'][0]['value'] = $model_desc;
    $form_state['input']['field_temporal_interval']['und'][0]['value'] = $time_unit;
    $form_state['input']['field_dev_create_date']['und'][0]['value'] = $creation_date;
    
  }
  
  private function get_files_in_dir($path){
    
    // create array to hold paths
    $return_array = array();
    // open model folder
    $dir = opendir($path);
    
    // search all paths in folder
    while(($file = readdir($dir)) !== false){
      
      if($file[0] == '.') continue;
      
      // get the full path of the file
      $fullpath = $path . '/' . $file;
      
      // if path is dir, search dir for files
      if(is_dir($fullpath)){
        $return_array = array_merge($return_array, $this->get_files_in_dir($fullpath));
      }
      // if path is file, add it to return array
      else{
        $return_array[] = $fullpath;
      }
    }
    
    return $return_array;
  }
}