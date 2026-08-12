<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.mediasanitize
 * @copyright   (C) 2026 Ponto Mega
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Language\Transliterate;

class PlgSystemMediasanitize extends CMSPlugin
{
    /**
     * Intercepts the request very early to sanitize uploaded filenames
     * before Joomla's Input or components process them.
     */
    public function onAfterInitialise()
    {
        if (empty($_FILES)) {
            return;
        }

        foreach ($_FILES as $key => $file) {
            if (isset($file['name'])) {
                if (is_array($file['name'])) {
                    // Handle multiple files array structure
                    foreach ($file['name'] as $i => $name) {
                        $_FILES[$key]['name'][$i] = $this->sanitizeFilename($name);
                    }
                } else {
                    // Handle single file
                    $_FILES[$key]['name'] = $this->sanitizeFilename($file['name']);
                }
            }
        }
    }

    /**
     * Intercepts media uploads from Joomla 4/5 new Media Manager API.
     * The context will be 'com_media.file'.
     */
    public function onContentBeforeSave($context, $article, $isNew, $data = null)
    {
        if ($context === 'com_media.file' && isset($article->name)) {
            $article->name = $this->sanitizeFilename($article->name);
        }
    }

    /**
     * Sanitizes the filename using Joomla's Transliterate class.
     *
     * @param   string  $filename  The original filename
     * @return  string  The sanitized filename
     */
    private function sanitizeFilename($filename)
    {
        if (empty($filename)) {
            return $filename;
        }

        // 1. Transliterar caracteres latinos para ASCII
        $filename = Transliterate::utf8_latin_to_ascii($filename);

        // 2. Aplicar formatação de maiúsculas/minúsculas de acordo com os parâmetros
        $caseFormat = $this->params->get('case_format', 'lowercase');
        if ($caseFormat === 'lowercase') {
            $filename = mb_strtolower($filename, 'UTF-8');
        } elseif ($caseFormat === 'uppercase') {
            $filename = mb_strtoupper($filename, 'UTF-8');
        }
        // Se for 'original', não altera

        // 3. Substituir espaços e caracteres indesejados por underline (_)
        $filename = preg_replace('/[^a-zA-Z0-9\._-]/', '_', $filename);

        // 4. Evitar múltiplos underlines seguidos (opcional, para ficar mais limpo)
        $filename = preg_replace('/_+/', '_', $filename);

        return $filename;
    }
}
