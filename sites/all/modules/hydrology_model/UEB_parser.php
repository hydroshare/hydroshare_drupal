<?php

class UEB
{
  
  /**
   *
   * Parse the core metadata from UEB model files
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
    
    # TODO: loop through NetCDF files instead
    # loop through the output files 

    foreach(glob($model_path.'/Outputs/*.txt') as $filename ){
    
      # open the file
      $handle = @fopen($filename,'r');
        
      $data_series_name = basename($filename,'.txt');
      
      # read output calculations
      if ($handle){
        
        // read the first line
        $buffer = fgets($handle, 4096);
        while ($buffer !== false){
          
          $i = 0;
          $line = array();
          while ($i < 70){

            # split the file by non-uniform delimiter            
            $elems = explode(' ',$buffer);
            foreach($elems as $elem){
              $val = trim($elem);
              if (strlen($val) > 0){
                $line[] = $val;
                $i++;
              }
            }

            // read the next line
            $buffer = fgets($handle, 4096);

            // exit if we've reached the end of the file
            if ($buffer == false){break;}
          }
          
          # create date object in m/d/Y H:i format
          $hour = sprintf("%02d",intval($line[3]));
          $dt = $line[1].'/'.$line[2].'/'.$line[0].' '.$hour.':00';
       
          # TODO: get other variable data too.
          # get total outflow
          $outflow = $line[25];
          
          // add values to array
          if (array_key_exists($data_series_name, $values)){
            array_push($values[$data_series_name],array($dt, $outflow));
            $volume_flow[$data_series_name] += $outflow;
          }
          else {
            $values[$data_series_name] = array(array($dt, $outflow));
            $volume_flow[$data_series_name] = 0.0;
          }
//        }
//          
      }
//
    }
//    

  }
      // return only the flow at the outlet (assumed to have the largest volume of outflow)
    $outlet = array_keys($volume_flow, max($volume_flow));
    
    return $values[$outlet[0]];
  }
  
  
  
  /**
   *
   * Returns the paths of all UEB model files
   */
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