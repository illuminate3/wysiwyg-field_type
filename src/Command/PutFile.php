<?php namespace Anomaly\WysiwygFieldType\Command;

use Anomaly\WysiwygFieldType\WysiwygFieldType;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;

/**
 * Class PutFile
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\WysiwygFieldType\Command
 */
class PutFile implements SelfHandling
{

    /**
     * The wysiwyg field type instance.
     *
     * @var WysiwygFieldType
     */
    protected $fieldType;

    /**
     * Create a new PutFile instance.
     *
     * @param WysiwygFieldType $fieldType
     */
    public function __construct(WysiwygFieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * Handle the command.
     *
     * @param Filesystem $files
     */
    public function handle(Filesystem $files)
    {
        $entry = $this->fieldType->getEntry();
        $path  = $this->fieldType->getStoragePath();

        if ($path && !is_dir(dirname($path))) {
            $files->makeDirectory(dirname($path), 0777, true, true);
        }

        if ($path) {
            $files->put($path, $entry->getRawAttribute($this->fieldType->getField()));
        }
    }
}
