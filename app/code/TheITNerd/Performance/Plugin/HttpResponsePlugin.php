<?php

namespace TheITNerd\Performance\Plugin;


use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http;
use TheITNerd\Performance\Helper\Config;

/**
 * Class HttpResponsePlugin
 * @package TheITNerd\Performance\Plugin
 */
class HttpResponsePlugin
{

    private const MATCH_REGEX = [
        'preload' => [
            'css' => '/href="([^>"]+\.css|.+css[0-9A-Za-z?=:+&,@;]+)"/',
            'js' => '/src="([^>"]+\.js)"/'
        ],
        'preconnect' => '/((src|href)="([^>"]+\.(ico|jpg|jpeg|png|gif|svg|js|css|swf|eot|ttf|otf|woff|woff2|json|webp))")/',
        'server_push' => [
            'image' => '/(src|href)="([^>"]+\.(ico|jpg|jpeg|png|gif|svg|webp))"/',
            'script' => '/(src)="([^>"]+\.js)"/',
            'style' => '/(href)="([^>"]+\.css|.+css[0-9A-Za-z?=:+&,@;]+)"/',
            'font' => '/(src|href)="([^>"]+\.(eot|ttf|otf|woff|woff2))"/'
        ]
    ];

    /**
     * @param Config $config
     * @param RequestInterface $request
     */
    public function __construct(
        private readonly Config           $config,
        private readonly RequestInterface $request
    )
    {

    }

    /**
     * @param Http $response
     * @return Http
     */
    public function beforeSendResponse(Http $response): Http
    {
        if (!$this->config->isEnabled() || !$this->canChangeRequest($response)) {
            return $response;
        }

        $body = $response->getBody();

        $this->addPreloads($body)
            ->addPreconnect($body)
            ->addServerPushHeader($response, $body);

        $response->setBody($body);

        return $response;
    }

    /**
     * @param Http $response
     * @return bool
     */
    private function canChangeRequest(Http $response): bool
    {
        if($this->request->isXMLHttpRequest()) {
            return false;
        }

        $body = $response->getBody();

        if(!str_contains($body, '<html')) {
            return false;
        }

        return true;

    }

    /**
     * @param Http $response
     * @param string $body
     * @return self
     */
    private function addServerPushHeader(Http $response, string $body): self
    {
        $items = [];
        foreach (self::MATCH_REGEX['server_push'] as $type => $regex) {
            preg_match_all($regex, $body, $matches, PREG_SET_ORDER);
            $matches = array_unique(array_column($matches, 2));

            foreach ($matches as $item) {
                $items[] = "<{$item}>; rel=preload; as={$type}";
            }
        }

        $response->setHeader("Link", implode(',', $items));

        return $this;
    }

    /**
     * @param string $body
     * @return self
     */
    private function addPreconnect(string &$body): self
    {

        preg_match_all(self::MATCH_REGEX['preconnect'], $body, $preconnectMatches, PREG_SET_ORDER);
        $preconnectMatches = array_column($preconnectMatches, 3);

        foreach ($preconnectMatches as $key => &$preconnectMatch) {
            $preconnectMatchParts = explode('/', ($preconnectMatch));

            if (isset($preconnectMatchParts[0], $preconnectMatchParts[1], $preconnectMatchParts[2])) {
                $preconnectMatch = '<link rel="preconnect" href="' . implode('/', [$preconnectMatchParts[0], $preconnectMatchParts[1], $preconnectMatchParts[2]]) . '">';
            } else {
                unset($preconnectMatches[$key]);
            }
        }

        foreach ($this->config->getAdditionalPreconnect() as $preconnectEntry) {
            $preconnectMatches[] = '<link rel="preconnect" href="' . trim($preconnectEntry) . '" crossorigin>';
        }

        $preconnectMatches = array_unique($preconnectMatches);
        $prefetchMatches = [];

        foreach ($preconnectMatches as $preconnectMatch) {
            $prefetchMatches[] = str_replace('preconnect', 'dns-prefetch', $preconnectMatch);
        }

        $preconnectMatches = array_merge($preconnectMatches, $prefetchMatches);

        $body = str_replace('</title>', "</title>\n" . implode("\n", $preconnectMatches), $body);

        return $this;
    }

    /**
     * @param string $body
     * @return self
     */
    private function addPreloads(string &$body): self
    {
        $this->addPreloadCSS($body)
            ->addPreloadJS($body);

        return $this;
    }

    /**
     * @param string $body
     * @return self
     */
    private function addPreloadJS(string &$body): self
    {
        preg_match_all(self::MATCH_REGEX['preload']['js'], $body, $jsMatches, PREG_SET_ORDER);
        $jsMatches = array_column($jsMatches, 1);

        foreach ($jsMatches as &$jsMatch) {
            $jsMatch = '<link rel="preload" href="' . $jsMatch . '" as="script" />';
        }
        unset($jsMatch);

        $jsMatches = array_unique($jsMatches);

        $body = str_replace('</title>', "</title>\n" . implode("\n", $jsMatches), $body);

        return $this;
    }

    /**
     * @param string $body
     * @return self
     */
    private function addPreloadCSS(string &$body): self
    {
        preg_match_all(self::MATCH_REGEX['preload']['css'], $body, $cssMatches, PREG_SET_ORDER);
        $cssMatches = array_column($cssMatches, 1);

        foreach ($cssMatches as &$cssMatch) {
            $cssMatch = '<link rel="preload" href="' . $cssMatch . '" as="style" />';
        }
        unset($cssMatch);

        $cssMatches = array_unique($cssMatches);

        $body = str_replace('</title>', "</title>\n" . implode("\n", $cssMatches), $body);

        return $this;
    }
}
