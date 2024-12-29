<?php
namespace BW_Detect_Mobile;

use Detection\Exception\MobileDetectException;
use Detection\MobileDetectStandalone;

class Start {
    private $detection;

    public function __construct() {
        // Utiliser la constante définie dans le fichier principal
        $plugin_path = BW_Detect_Mobile_DIR;

        // Inclure les fichiers nécessaires
        require_once $plugin_path . 'Mobile-Detect/standalone/autoloader.php';
        require_once $plugin_path . 'Mobile-Detect/src/MobileDetectStandalone.php';

        try {
            $this->detection = new MobileDetectStandalone();
            $this->detection->setUserAgent($_SERVER['HTTP_USER_AGENT'] ?? 'iPad');
        } catch (MobileDetectException $e) {
            error_log('Mobile Detect Error: ' . $e->getMessage());
        }
    }

    public function init() {
        try {
            return [
                'detection' => $this->detection,
                'isMobile' => $this->detection->isMobile()
            ];
        } catch (MobileDetectException $e) {
            error_log('Mobile Detect Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getDetection() {
        return $this->detection;
    }
}
