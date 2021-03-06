<?php

namespace Dtc\GridBundle\Grid\Renderer;

use Symfony\Component\Routing\Router;
use Symfony\Bundle\TwigBundle\TwigEngine;

class RendererFactory
{
    protected $twigEngine;
    protected $router;
    protected $themeCss;
    protected $themeJs;
    protected $pageDivStyle;
    protected $jqGridJs;
    protected $jqGridCss;
    protected $dataTablesCss;
    protected $dataTablesJs;
    protected $jQuery;
    protected $purl;

    public function __construct(
        TwigEngine $twigEngine,
                                Router $router,
                                array $config
    ) {
        $this->twigEngine = $twigEngine;
        $this->router = $router;
        $this->themeCss = $config['theme.css'];
        $this->themeJs = $config['theme.js'];
        $this->pageDivStyle = $config['page_div_style'];
        $this->jQuery = $config['jquery'];
        $this->purl = $config['purl'];
        $this->dataTablesCss = $config['datatables.css'];
        $this->dataTablesJs = $config['datatables.js'];
        $this->jqGridCss = $config['jq_grid.css'];
        $this->jqGridJs = $config['jq_grid.js'];
    }

    /**
     * Creates a new renderer of type $type, throws an exception if it's not known how to create a renderer of type $type.
     *
     * @param $type
     *
     * @return AbstractRenderer
     */
    public function create($type)
    {
        switch ($type) {
            case 'datatables':
                $renderer = new DataTablesRenderer($this->twigEngine, $this->router);
                break;
            case 'jq_grid':
                $renderer = new JQGridRenderer($this->twigEngine, $this->router);
                break;
            case 'table':
                $renderer = new TableGridRenderer($this->twigEngine, $this->router);
                break;
            default:
                throw new \Exception("No renderer for type '$type''");
        }

        if (method_exists($renderer, 'setThemeCss')) {
            $renderer->setThemeCss($this->themeCss);
        }

        if (method_exists($renderer, 'setThemeJs')) {
            $renderer->setThemeJs($this->themeJs);
        }

        if (method_exists($renderer, 'setJQuery')) {
            $renderer->setJQuery($this->jQuery);
        }

        if (method_exists($renderer, 'setPurl')) {
            $renderer->setPurl($this->purl);
        }

        if (method_exists($renderer, 'setPageDivStyle')) {
            $renderer->setPageDivStyle($this->pageDivStyle);
        }

        if (method_exists($renderer, 'setJqGridCss')) {
            $renderer->setJqGridCss($this->jqGridCss);
        }

        if (method_exists($renderer, 'setJqGridJs')) {
            $renderer->setJqGridJs($this->jqGridJs);
        }

        if (method_exists($renderer, 'setDataTablesCss')) {
            $renderer->setDataTablesCss($this->dataTablesCss);
        }

        if (method_exists($renderer, 'setDataTablesJs')) {
            $renderer->setDataTablesJs($this->dataTablesJs);
        }

        return $renderer;
    }
}
