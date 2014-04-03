<?php
namespace App\Exporter\Writer;

use Exporter\Writer\WriterInterface;
use Knp\Snappy\GeneratorInterface;
use Symfony\Component\Templating\EngineInterface;

class PdfWriter implements WriterInterface
{
    /**
     * @var string
     */
    protected $filename;

    protected $file;

    private $data = [];
    /**
     * @var \Knp\Snappy\GeneratorInterface
     */
    protected $generator;

    /**
     * @param $filename
     * @param GeneratorInterface $generator
     * @param EngineInterface    $templating
     * @param $template
     */
    public function __construct($filename, GeneratorInterface $generator, EngineInterface $templating, $template)
    {
        $this->filename = $filename;
        $this->generator = $generator;
        $this->templating = $templating;
        $this->template = $template;

        if (is_file($filename)) {
            throw new \RuntimeException(sprintf('The file %s already exist', $filename));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function open()
    {
        $this->file = fopen($this->filename, 'w', false);
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $html = $this->templating->render(
            $this->template,
            [
                'data' => $this->data
            ]
        );

        fwrite($this->file, $this->generator->getOutputFromHtml($html));

        fclose($this->file);
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $data)
    {
        array_push($this->data, $data);
    }
}
