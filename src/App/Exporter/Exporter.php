<?php
namespace App\Exporter;

use App\Exporter\Writer\PdfWriter;
use Exporter\Handler;
use Sonata\CoreBundle\Exporter\Exporter as Base;
use Knp\Snappy\GeneratorInterface;
use Exporter\Source\SourceIteratorInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Templating\EngineInterface;

class Exporter extends Base
{
    /**
     * @var GeneratorInterface
     */
    private $pdfEngine;
    /**
     * @var EngineInterface
     */
    private $templateEngine;

    /**
     * @param GeneratorInterface $pdfEngine
     */
    public function setPdfEngine(GeneratorInterface $pdfEngine)
    {
        $this->pdfEngine = $pdfEngine;
    }

    /**
     * @param EngineInterface $templateEngine
     */
    public function setTemplateEngine(EngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function getResponse($format, $filename, SourceIteratorInterface $source, $template = null)
    {
        if ('pdf' !== $format) {
            return parent::getResponse($format, $filename, $source);
        }
        switch ($format) {
            case 'pdf':
                $writer = new PdfWriter('php://output', $this->pdfEngine, $this->templateEngine, $template);
                $contentType = 'application/pdf';
                break;
            default:
                throw new \RuntimeException('Invalid export format type');
        }
        $callback = function () use ($source, $writer) {
            $handler = Handler::create($source, $writer);
            $handler->export();
        };

        return new StreamedResponse($callback, 200, [
            'Content-Type' => $contentType,
            'Content-Disposition' => sprintf('attachment; filename=%s', $filename)
        ]);
    }
}
