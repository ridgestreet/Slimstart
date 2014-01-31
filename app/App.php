<?php
    define('ROOT', dirname(__FILE__) . '/../');
    define('EXTERNALS_ROOT', ROOT . '/externals/');
    define('TEMPLATE_ROOT', ROOT . 'templates/');
    define('WWW_ROOT', ROOT . 'www/');
    
    set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, array(ROOT, EXTERNALS_ROOT)));
    
    require dirname(__FILE__) . '/../vendor/autoload.php';

    Mustache_Autoloader::register();

    class App {
        
        private $mustache, $templates, $template_path, $memcached;
        public $slim; //If you wanna go directly at $app->slim->somehting
        
        public function __construct(){
            $this->slim = new \Slim\Slim();
            $this->template_path = TEMPLATE_ROOT;
            $this->templates = $this->_get_templates(TEMPLATE_ROOT); //TODO: Cache in Memcache
            $this->mustache = new Mustache_Engine(array(
              'partials' => $this->templates['partials']
            ));
            // $this->memcached = new Memcached;
        }
        
        public function render($view, $data = array(), $contentType = 'html') {
          $defaults = array();
          
          $data = array_merge($defaults, $data);
          
          if($contentType === 'html') {
            return $this->_render($view, $data);
          } else if ($contentType === 'json') {
            $this->slim->response()->header('Content-Type', 'application/json');
            return json_encode($data);
          }
        }
        
        private function _render ($view, $data, $layout = 'layout.html') {
          $page_template = $this->template_path . $view;
          $layout_template = $this->template_path . $layout;
          
          if (file_exists($page_template) && file_exists($layout_template)) {
            $data['page'] = $this->mustache->render(file_get_contents($page_template), $data, $this->templates['partials']);
            $full_page_content = $this->mustache->render(file_get_contents($layout_template), $data, $this->templates['partials']);
            return $full_page_content;
          } 
        }
        
        public function get($route, $callback){
            return $this->slim->get($route, $callback);
        }
        
        public function post($route, $callback){
            return $this->slim->post($route, $callback);
        }
        
        public function run(){
            $this->slim->run();
        }
        
        public function templates(){
            $response = $this->templates;
            $json = json_encode($response);
            return $json;
        }
        
        private function _read_template($template){
            $file_content = "";
           
            $file_name = $this->template_path . '/' . $template . '.html';
            if(file_exists($file_name)){
                $file_content = file_get_contents($file_name);
            }
            return $file_content;
        }
        
        private function _get_key($str){
            $pattern = "/^([\w-_]+)\.(\w+)$/";
            if(preg_match($pattern, $str, $matches)){
                return $matches[1];
            }
            return $str;
        }
        
        private function _get_templates($dir) { 
            $files = array(); 

            if ($handle = opendir($dir)) {
                while (false !== ($file = readdir($handle))) { 

                    if ($file != "." && $file != "..") { 
                        if(is_dir($dir.'/'.$file)) {
                            $key = $this->_get_key($file); 
                            $dir2 = $dir.'/'.$file; 
                            $files[$key] = $this->_get_templates($dir2); 
                        } 
                        else {
                            $key = $this->_get_key($file);
                            $template = file_get_contents($dir.'/'.$file);
                            $template =  preg_replace('~\s+~', ' ', trim($template)); 
                            $template = str_replace('> <', '><', $template);
                            $files[$key] = $template;
                        } 
                    } 
                } 
                closedir($handle); 
            }
            return $files;
        }
    }