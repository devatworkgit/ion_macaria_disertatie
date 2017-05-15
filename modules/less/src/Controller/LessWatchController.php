<?php

namespace Drupal\less\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Utility\UrlHelper;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LessWatchController extends ControllerBase {
  
  /**
   * Callback for `my-api/post.json` API method.
   */
  public function _less_watch( Request $request ) {

    // This condition checks the `Content-type` and makes sure to 
    // decode JSON string from the request body into array.
    if ( 0 === strpos( $request->headers->get( 'Content-Type' ), 'application/json' ) ) {
      $data = json_decode( $request->getContent(), TRUE );
      $request->request->replace( is_array( $data ) ? $data : [] );
    }
    
    $theme = \Drupal::config('system.theme')->get('default');
    
    $changed_files = array();
    
    $config = \Drupal::config('less.settings');
    
    if ($config->get(LESS_WATCH) ?: FALSE) {
      $files = (isset($_POST['less_files']) && is_array($_POST['less_files'])) ? $_POST['less_files'] : array();
      
      foreach ($files as $file) {
        
        $file_url_parts = UrlHelper::parse($file);
        
        if ($cache = \Drupal::cache()->get('less:watch:' . \Drupal\Component\Utility\Crypt::hashBase64($file_url_parts['path']))) {
          
          $cached_data = $cache->data; 
          
          $input_file = $cached_data['less']['input_file'];
          
          $output_file = $cached_data['less']['output_file'];
          
          $current_mtime = filemtime($output_file);
          
          $theme = $cached_data['less']['theme'];
          
          $styles = array(
            '#items' => array(
              $input_file => $cached_data,
            ),
          );
          
          //$styles = _less_pre_render($styles);
          
          if (filemtime($styles['#items'][$input_file]['data']) > $current_mtime) {
            $changed_files[] = array(
              'old_file' => $file_url_parts['path'],
              'new_file' => file_create_url($styles['#items'][$input_file]['data']),
            );
          }
        }
      }
    }

    return new JsonResponse($changed_files);
  }

  /* public function _less_watch() {
    
    global $theme;
    
    
    
    
    if ($config->get(LESS_WATCH) ?: FALSE) {
      
      $files = (isset($_POST['less_files']) && is_array($_POST['less_files'])) ? $_POST['less_files'] : array();
      
      foreach ($files as $file) {
        
        $file_url_parts = drupal_parse_url($file);
        
        if ($cache = \Drupal::cache()->get('less:watch:' . \Drupal\Component\Utility\Crypt::hashBase64($file['data']))) {
          
          kint($cache);
          $cached_data = $cache->data;
          
          $input_file = $cached_data['less']['input_file'];
          
          $output_file = $cached_data['less']['output_file'];
          
          $current_mtime = filemtime($output_file);
          
          $theme = $cached_data['less']['theme'];
          
          $styles = array(
            '#items' => array(
              $input_file => $cached_data,
            ),
          );
          
          $styles = _less_pre_render($styles);
          
          if (filemtime($styles['#items'][$input_file]['data']) > $current_mtime) {
            $changed_files[] = array(
              'old_file' => $file_url_parts['path'],
              'new_file' => file_create_url($styles['#items'][$input_file]['data']),
            );
          }
        }
      }
    }
    
    return $changed_files;
  } */
  
}