<?php

namespace App\Controller\Sonata;

use Sonata\AdminBundle\Controller\CRUDController as Base;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CRUDController extends Base
{
    /**
     * @param Request $request
     *
     * @throws \RuntimeException
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function exportAction(Request $request)
    {

        if (false === $this->admin->isGranted('EXPORT')) {
            throw new AccessDeniedException();
        }

        $format = $request->get('format');

        $allowedExportFormats = (array) $this->admin->getExportFormats();

        if (!in_array($format, $allowedExportFormats)) {
            throw new \RuntimeException(sprintf(
                'Export in format `%s` is not allowed for class: `%s`. Allowed formats are: `%s`',
                $format,
                $this->admin->getClass(),
                implode(', ', $allowedExportFormats)
            ));
        }
        $processedAdminName = substr($this->admin->getClass(), strripos($this->admin->getClass(), '\\') + 1);
        $filename = sprintf(
            'export_%s_%s.%s',
            strtolower($processedAdminName),
            date('Y_m_d_H_i_s', strtotime('now')),
            $format
        );
        $templatePath = sprintf('%s:Export/%s:%s.html.twig', 'App', strtoupper($format), $processedAdminName);

        return $this->get('sonata.admin.exporter')->getResponse(
            $format,
            $filename,
            $this->admin->getDataSourceIterator(),
            $templatePath
        );
    }
}
