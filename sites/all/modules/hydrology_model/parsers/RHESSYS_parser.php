<?php

class RHESSYS
{
  
  /**
   *
   * Parse the core metadata from RHESSYS model files
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

    
    
    // get all RHESSYS model file paths
    $files = $this->get_files_in_dir($model_path);
    
    
    // get the metadata.txt path
    $metadata_path = $files[key(preg_grep('/metadata.txt$/',$files))];
    
    $ini = parse_ini_file($metadata_path, true, INI_SCANNER_RAW);
    
    // get ini metadata entries
    //$ini = $this->read_metadata_ini($metadata_path);

    // set spatial fields
    $form_state['input']['field_spatial_bbox']['und'][0]['value'] = $ini['study_area']['bbox_wgs84'];
    $form_state['input']['field_spatial_resolution']['und'][0]['value'] = $ini['study_area']['dem_res_x'];
    $form_state['input']['field_spatial_reference']['und'][0]['value'] = $ini['study_area']['dem_srs'];
    $pt = 'east='.$ini['study_area']['gage_lon_wgs84'].'; north='.$ini['study_area']['gage_lat_wgs84'].'; name='.$ini['study_area']['gage_id'];
    $form_state['input']['field_spatial_location']['und'][0]['value'] = $pt;

    // get model runs
    $runs = explode(',',$ini['model_run']['runs']);
    $default_run = array_shift($runs);

    // get simulation start and end time
    $cmd = $ini['model_run'][$default_run.'_command'];
    $args = explode('-',$cmd);
    $kvp = array();
    for($i = 0; $i < count($args); $i++){
      $arg = explode(' ', $args[$i], 2);
      $kvp[] = $arg[0].'='.$arg[1];
    } 
    parse_str(implode('&', $kvp),$arg_kvp);

    // set resource identification fields
    $form_state['input']['field_id_description']['und'][0]['value'] = $ini['model_run'][$default_run.'_description'];
    
    //set temportal fields
    $st = explode(' ',$arg_kvp['st']);
    $et = explode(' ',$arg_kvp['ed']);
    $form_state['input']['field_temporal_begin']['und'][0]['value'] = $st[1].'/'.$st[2].'/'.$st[0].' '.$st[3].':00';
    $form_state['input']['field_temporal_end']['und'][0]['value'] = $et[1].'/'.$et[2].'/'.$et[0].' '.$et[3].':00'; 
    
    // set development fields
    $form_state['input']['field_dev_create_date']['und'][0]['value'] = $ini['model_run'][$default_run.'_date_utc'];
    

//            // get simulation start
//            $str_start = DateTime::createFromFormat('Y m d H',preg_replace('!\s+!', ' ',substr($buffer,0,13)))->format('m/d/Y');  
//            // get simulation end
//            $str_end = DateTime::createFromFormat('Y m d H',preg_replace('!\s+!', ' ',substr($buffer,0,13)))->format('m/d/Y');
//            // get time step in seconds
//            $time_unit = intval(trim(substr($buffer,0,4)));
//            // convert time unit from hours into seconds
//            $time_unit *= 3600;
//            // get utc offset
//            $offset = intval(trim(substr($buffer,0,4))); 
//      $model_desc = fgets($handle, 4096);
//    // set form values --> $form_state['complete form']['post_fieldset']['post_id']['#value'] = $my_value;
//    $form_state['input']['field_temporal_begin']['und'][0]['value'] = $str_start;
//    $form_state['input']['field_temporal_end']['und'][0]['value'] = $str_end; 
//    $form_state['input']['field_temporal_interval']['und'][0]['value'] = $time_unit;
//    
    
  }
  

  
  /**
   *
   * Return a single output data series for plotting
   */
  public function get_single_output($node, $model_path){
    
    
    // TODO: Implement plotting of Rhesyss models
    
//    // get simulation start time
//    $begin = $node->field_temporal_begin['und'][0]['safe_value'];
//    $start_dt = datetime::createfromformat('m/d/Y H:i:s',$begin.' 00:00:00');
//    
//    // get output values
//    $volume_flow = array();
//    $date = array();
//    $values = array();
//    
//    # TODO: loop through NetCDF files instead
//    # loop through the output files 
//
//    foreach(glob($model_path.'/Outputs/*.txt') as $filename ){
//    
//      # open the file
//      $handle = @fopen($filename,'r');
//        
//      $data_series_name = basename($filename,'.txt');
//      
//      # read output calculations
//      if ($handle){
//        
//        // read the first line
//        $buffer = fgets($handle, 4096);
//        while ($buffer !== false){
//          
//          $i = 0;
//          $line = array();
//          while ($i < 70){
//
//            # split the file by non-uniform delimiter            
//            $elems = explode(' ',$buffer);
//            foreach($elems as $elem){
//              $val = trim($elem);
//              if (strlen($val) > 0){
//                $line[] = $val;
//                $i++;
//              }
//            }
//
//            // read the next line
//            $buffer = fgets($handle, 4096);
//
//            // exit if we've reached the end of the file
//            if ($buffer == false){break;}
//          }
//          
//          # create date object in m/d/Y H:i format
//          $hour = sprintf("%02d",intval($line[3]));
//          $dt = $line[1].'/'.$line[2].'/'.$line[0].' '.$hour.':00';
//       
//          # TODO: get other variable data too.
//          # get total outflow
//          $outflow = $line[25];
//          
//          // add values to array
//          if (array_key_exists($data_series_name, $values)){
//            array_push($values[$data_series_name],array($dt, $outflow));
//            $volume_flow[$data_series_name] += $outflow;
//          }
//          else {
//            $values[$data_series_name] = array(array($dt, $outflow));
//            $volume_flow[$data_series_name] = 0.0;
//          }
////        }
////          
//      }
////
//    }
////    
//
//  }
//      // return only the flow at the outlet (assumed to have the largest volume of outflow)
//    $outlet = array_keys($volume_flow, max($volume_flow));
//    
//    return $values[$outlet[0]];
  }
  
  /**
   * 
   * Parses RHESSYS metadata.txt and returns key-value array of its contents
   * @param string $metadata_path
   * @return array ini_entries
   */
  public function read_metadata_ini($metadata_path){
    
    // parse the metadata file (doing it this way b/c parse_ini throws error with "none" and extra "=")
    $ini = nl2br(file_get_contents($metadata_path));
    //$br = nl2br($ini);
    $ini_list = explode('<br />',$ini);
    
    $ini_dict = array();
    for($i = 0; $i < count($ini_list); ++$i ){
      $parent = trim($ini_list[$i]);
      if (substr($parent,0,1) == "["){
        
        // create kvp array
        $kvp = array();
        
        
        // get the first key value pair
        $i++;
        $elem = trim($ini_list[$i]);
        
        // add key value pairs
        while (!empty($elem)){
          $kv = explode('=',$elem,2);
          $kvp[trim($kv[0])] = trim($kv[1]);
          $i++;
          $elem = trim($ini_list[$i]);
        }
        
        // add the kvp array back into the parent
        $ini_dict[substr($parent,1,-1)] = $kvp;
      }
      
    }
    
    return $ini_dict;
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