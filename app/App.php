<?
    define('ROOT', dirname(__FILE__) . '/../');
    define('EXTERNALS_ROOT', ROOT . '/externals/');
    define('TEMPLATE_ROOT', ROOT . '/templates/');
    
    set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, array(ROOT, EXTERNALS_ROOT)));
    
    require "slim/Slim.php";
    require "mustache/Mustache.php";
    
    class App {
        
        private $mustache, $templates, $template_path;
        public $slim; //If you wanna go directly at $app->slim->somehting
        
        public function __construct(){
            $this->slim = new Slim();
            $this->template_path = TEMPLATE_ROOT;
            $this->templates = array(); //TODO: Read into an array that can be used in order to expose client side
        }
        
        public function render($view, $data = array(), $layout = 'layout'){
            
            /*
            
            Need to set up a way to filter data before supporting this
            
            if($this->slim->request()->headers('X-Requested-With')) {
                $content = json_encode($data);
                return $content;
            }
            
            */
            
            $this->mustache = new Mustache();
            
            $view = str_replace('_', '/', $view);
            $layout = str_replace('_', '/', $layout);

            $content = "";      
                  
            $layout_template = $this->_read_template($layout);
            $view_template = $this->_read_template($view);
            
            if(array_key_exists('partials', $this->templates)) {
                $data['content'] = $this->mustache->render($view_template, $data, $this->templates['partials']);
                $content = $this->mustache->render($layout_template, $data, $this->templates['partials']);
            } else {
                $data['content'] = $this->mustache->render($view_template, $data);
                $content = $this->mustache->render($layout_template, $data);
            }
            
            return $content;
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
        
        private function _read_template($template){
            $file_content = "";
           
            $file_name = $this->template_path . '/' . $template . '.html';
            if(file_exists($file_name)){
                $file_content = file_get_contents($file_name);
            }
            return $file_content;
        }
    }
?>