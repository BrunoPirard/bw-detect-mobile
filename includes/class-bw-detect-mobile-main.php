<?php 
namespace BW_Detect_Mobile;

class Main {
    protected string $version = BW_Detect_Mobile_VERSION;
    private static $instance = null;
    private $detector;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     *
     * Runs when the class is instantiated.
     *
     * @since 0.3.0
     * @access private
     *
     * @return void
     */
    private function __construct() {
        require_once BW_Detect_Mobile_DIR . 'includes/helpers.php';
        
        $this->setup_autoloader();
        
        add_action('init', [$this, 'init'], 20);
        add_action('plugins_loaded', [$this, 'load_plugin_textdomain']);
    }

    /**
     * Registers an autoloader function for classes within the BW_Detect_Mobile namespace.
     *
     * The autoloader converts the class name into a file path by removing the namespace prefix,
     * replacing underscores with hyphens, and appending the result to the includes directory.
     * If the constructed file path exists, the file is included.
     *
     * @return void
     */

    private function setup_autoloader() {
        spl_autoload_register(function ($class) {
            $prefix = 'BW_Detect_Mobile\\';
            
            if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
                return;
            }

            $relative_class = substr($class, strlen($prefix));
            $file_name = strtolower(str_replace('_', '-', $relative_class));
            $file = BW_Detect_Mobile_DIR . 'includes/class-bw-detect-mobile-' . $file_name . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }

    /**
     * Load the plugin textdomain for translations.
     *
     * @since 0.3.0
     *
     * @return void
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'bw-detect-mobile',
            false,
            dirname(plugin_basename(BW_Detect_Mobile_FILE)) . '/languages/'
        );
    }


    /**
     * Initializes the mobile detection system.
     *
     * Checks for the existence of the Mobile-Detect library and initializes
     * the detection instance. If Bricks Builder is available and the detection
     * instance is valid, it initializes Bricks with the detection instance.
     * Logs an error if the Mobile-Detect library is not found or if any
     * exceptions occur during initialization.
     *
     * @since 0.3.0
     *
     * @return void
     */
    public function init() {
        try {
            if (!file_exists(BW_Detect_Mobile_DIR . 'Mobile-Detect/standalone/autoloader.php')) {
                throw new \Exception('Mobile-Detect library not found');
            }

            $this->detector = new \BW_Detect_Mobile\Start();
            $detection_instance = $this->detector->init();

            if (defined('BRICKS_VERSION')) {
                
                if ($detection_instance && isset($detection_instance['detection'])) {
                    new \BW_Detect_Mobile\Bricks($detection_instance['detection']);
                }
            }

        } catch (\Exception $e) {
            error_log("BW Detect Mobile Error: " . $e->getMessage());
        }
    }
  
    /**
     * Initializes Bricks with the mobile detection instance.
     *
     * If the Bricks Builder is available and the detection instance is valid, it
     * initializes Bricks with the detection instance. If the detection instance
     * is not valid, it does nothing.
     *
     * @since 0.3.0
     *
     * @param array $detection_instance The mobile detection instance. If not valid, the method does nothing.
     * @return void
     */
    public function init_bricks($detection_instance) {
        if (!defined('BRICKS_VERSION')) {
            return;
        }
        
        if ($detection_instance && isset($detection_instance['detection'])) {
            
            // Initialiser une seule fois
            static $initialized = false;
            if (!$initialized) {
                new \BW_Detect_Mobile\Bricks($detection_instance['detection']);
                $initialized = true;
            }
        }
    }

    /**
     * Retrieves the mobile detection instance.
     *
     * Initializes the detector if it hasn't been initialized yet, and returns
     * the detection instance. Utilizes a static variable to ensure the detector
     * is only initialized once per request.
     *
     * @return mixed|null The detection instance if available, or null if not initialized.
     */
    public static function get_detector() {
        static $detector = null;
        
        if ($detector === null) {
            $start = new \BW_Detect_Mobile\Start();
            $instance = $start->init();
            $detector = $instance['detection'] ?? null;
        }
        
        return $detector;
    }

    /**
     * Retrieves the mobile detection instance.
     *
     * Alias for BW_Detect_Mobile_Main::get_detector().
     *
     * @return mixed|null The detection instance if available, or null if not initialized.
     *
     * @since 0.1.0
     */
    function bw_detect() {
        return \BW_Detect_Mobile\Main::get_detector();
    }
}
